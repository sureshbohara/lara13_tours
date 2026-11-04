<?php
declare(strict_types=1);

namespace App\Services\Admin;

use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProductVariantService extends BaseCrudService
{
    public function __construct(ProductVariant $model, MediaService $mediaService)
    {
        parent::__construct($model, $mediaService, 'products/variants');
    }

    public function getVariants(int $productId)
    {
        return $this->model->where('product_id', $productId)->get();
    }

    public function storeVariant(int $productId, array $data): ProductVariant
    {
        return DB::transaction(function () use ($productId, $data) {
            $data['product_id'] = $productId;
            $this->handleImage($data, null, 'image');
            return $this->model->create($data);
        });
    }

    public function updateVariant(int $id, array $data): ProductVariant
    {
        return DB::transaction(function () use ($id, $data) {
            $variant = $this->model->findOrFail($id);
            $this->handleImage($data, $variant, 'image');
            $variant->update($data);
            return $variant->fresh();
        });
    }
}