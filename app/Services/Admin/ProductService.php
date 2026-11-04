<?php
declare(strict_types=1);

namespace App\Services\Admin;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class ProductService extends BaseCrudService
{
    public function __construct(Product $model, MediaService $mediaService)
    {
        parent::__construct($model, $mediaService, 'products');
    }

    public function storeProduct(array $data): Product
    {
        return DB::transaction(function () use ($data) {
            $bundleProducts = $data['bundle_products'] ?? [];
            unset($data['bundle_products']);

            $this->handleProductImages($data, null);
        
            $product = $this->model->create($data);
            $this->syncBundles($product, $bundleProducts);

            return $product->fresh(['brand', 'category', 'bundles']);
        });
    }

    public function updateProduct(int $id, array $data): Product
    {
        return DB::transaction(function () use ($id, $data) {
            $product = $this->model->findOrFail($id);
            
            $bundleProducts = $data['bundle_products'] ?? [];
            unset($data['bundle_products']);

            $this->handleProductImages($data, $product);
            
            $product->update($data);

            $this->syncBundles($product, $bundleProducts);

            return $product->fresh(['brand', 'category', 'bundles']);
        });
    }

    protected function syncBundles(Product $product, array $bundleProducts): void
    {
 
        $product->bundles()->delete();

        if (!empty($bundleProducts)) {
            foreach ($bundleProducts as $bundle) {
                $childId = $bundle['child_product_id'] ?? $bundle['product_id'] ?? null;
                
                if ($childId) {
                    $product->bundles()->create([
                        'parent_product_id' => $product->id,
                        'product_id'        => $childId, 
                        'quantity'          => $bundle['quantity'] ?? 1,
                    ]);
                }
            }
        }
    }

    public function toggleFeatured(int $id): bool
    {
        $product = $this->model->findOrFail($id);
        $product->is_featured = !$product->is_featured;
        $product->save();
        return (bool) $product->is_featured;
    }

    public function deleteGalleryImage(int $id, string $imageName): void
    {
        $product = $this->model->findOrFail($id);
        $gallery = $product->gallery ?? [];

        if (($key = array_search($imageName, $gallery)) !== false) {
            unset($gallery[$key]);
            $product->gallery = array_values($gallery);
            $product->save();

            $absolutePath = public_path('images/' . ltrim($imageName, '/'));
            if (file_exists($absolutePath)) {
                unlink($absolutePath);
            }
        }
    }

    protected function deleteAssociatedImages(Model $item): void
    {
        if ($item->image) {
            $this->mediaService->deleteImageVariants($item->image);
        }
        foreach ($item->gallery ?? [] as $galleryImage) {
            $this->mediaService->deleteImageVariants($galleryImage);
        }
    }

    protected function handleProductImages(array &$data, ?Product $product): void
    {
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            if ($product && $product->image) {
                $this->mediaService->deleteImageVariants($product->image);
            }
            $data['image'] = $this->mediaService->uploadImage($data['image'], 'products/images');
        } elseif (array_key_exists('image', $data) && $data['image'] === null) {
            if ($product && $product->image) {
                $this->mediaService->deleteImageVariants($product->image);
            }
            $data['image'] = null;
        } else {
            unset($data['image']);
        }

        if (isset($data['gallery']) && is_array($data['gallery'])) {
            $existingGallery = $product ? ($product->gallery ?? []) : [];
            foreach ($data['gallery'] as $file) {
                if ($file instanceof UploadedFile) {
                    $path = $this->mediaService->uploadImage($file, 'products/gallery');
                    $existingGallery[] = $path;
                }
            }
            $data['gallery'] = $existingGallery;
        } else {
            unset($data['gallery']);
        }
    }
}