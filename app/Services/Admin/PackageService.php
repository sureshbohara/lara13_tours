<?php

declare(strict_types=1);

namespace App\Services\Admin;

use App\Models\FixedDeparture;
use App\Models\Package;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
class PackageService
{
    public function __construct(
        protected Package $model,
        protected MediaService $mediaService
    ) {}

    public function getPackages(array $filters = [])
    {
        return $this->model::getFilteredRecords($filters);
    }

    public function storePackage(array $data, array $categoryIds = [])
    {
        return DB::transaction(function () use ($data, $categoryIds) {
            $this->handleImages($data, null);

            $data['created_by'] = Auth::guard('admin')->id();
            $data['updated_by'] = Auth::guard('admin')->id();

            $package = $this->model->create($data);
            $package->categories()->sync($categoryIds);
            return $package->fresh(['categories', 'creator']);
        });
    }

    public function updatePackage(int $id, array $data, array $categoryIds = [])
    {
        return DB::transaction(function () use ($id, $data, $categoryIds) {
            $package = $this->model->findOrFail($id);
            $this->handleImages($data, $package);
            $data['updated_by'] = Auth::guard('admin')->id();
            $package->update($data);
            $package->categories()->sync($categoryIds);
            return $package->fresh(['categories', 'updater']);
        });
    }

    public function deletePackage(int $id): bool
    {
        $package = $this->model->findOrFail($id);
        
        if ($package->image) {
            $this->mediaService->deleteImageVariants($package->image);
        }
        if ($package->feature_image) {
            $this->mediaService->deleteImageVariants($package->feature_image);
        }
        
        return $package->delete();
    }

    public function toggleStatus(int $id): bool
    {
        $package = $this->model->findOrFail($id);
        $package->status = !$package->status;
        $package->save();
        return $package->status;
    }

    public function updateOrderLevel(int $id, int $orderLevel): bool
    {
        return $this->model->findOrFail($id)->update(['order_level' => $orderLevel]);
    }

    public function updateDisplayType(int $id, ?string $displayOn): bool
    {
        return $this->model->findOrFail($id)->update(['display_on' => $displayOn]);
    }

    public function updatePrices(int $id, array $data): bool
    {
        return $this->model->findOrFail($id)->update($data);
    }



    public function deleteGalleryImage(int $id, string $imageName): void
    {
        $package = $this->model->findOrFail($id);
        $gallery = $package->gallery ?? [];
        
        if (($key = array_search($imageName, $gallery)) !== false) {
            unset($gallery[$key]);
            $package->gallery = array_values($gallery); 
            $package->save();
            $absolutePath = public_path('images/' . $imageName);
            if (file_exists($absolutePath)) {
                unlink($absolutePath);
            }
        }
    }



    public function updateItinerary(int $id, array $data): bool
    {
        $package = $this->model->findOrFail($id);
        $itinerarySteps = [];
        $titles = $data['title'] ?? [];
        $count = is_array($titles) ? count($titles) : 0;
        
        for ($i = 0; $i < $count; $i++) {
            $itinerarySteps[] = [
                'name'          => $titles[$i] ?? '',
                'content'       => $data['content'][$i] ?? '',
                'max_elevation' => $data['max_elevation'][$i] ?? '',
                'duration'      => $data['duration'][$i] ?? '',
                'distance'      => $data['distance'][$i] ?? '',
                'meals'         => $data['meals'][$i] ?? '',
                'accommodation' => $data['accommodation'][$i] ?? '',
            ];
        }
        
        $package->itinerary_data = $itinerarySteps;
        return $package->save();
    }

    public function updateIncExc(int $id, array $data): bool
    {
        $package = $this->model->findOrFail($id);
        $includedItems = [];
        if (isset($data['included']['content']) && is_array($data['included']['content'])) {
            foreach ($data['included']['content'] as $content) {
                if (!empty(trim((string) $content))) {
                    $includedItems[] = ['content' => trim((string) $content)];
                }
            }
        }

  
        $excludedItems = [];
        if (isset($data['excluded']['content']) && is_array($data['excluded']['content'])) {
            foreach ($data['excluded']['content'] as $content) {
                if (!empty(trim((string) $content))) {
                    $excludedItems[] = ['content' => trim((string) $content)];
                }
            }
        }

        $package->included_data = $includedItems;
        $package->excluded_data = $excludedItems;

        return $package->save();
    }

    public function updateEquipment(int $id, array $data): bool
    {
        $package = $this->model->findOrFail($id);

        $transformEquipment = function (array $equipmentData): array {
            $items = [];
            if (isset($equipmentData['content']) && is_array($equipmentData['content'])) {
                foreach ($equipmentData['content'] as $content) {
                    if (!empty(trim((string) $content))) {
                        $items[] = ['content' => trim((string) $content)];
                    }
                }
            }
            return $items;
        };

        $package->general     = $transformEquipment($data['equipment1'] ?? []);
        $package->lower_body  = $transformEquipment($data['equipment2'] ?? []);
        $package->upper_body  = $transformEquipment($data['equipment3'] ?? []);
        $package->footwear    = $transformEquipment($data['equipment4'] ?? []);
        $package->accessories = $transformEquipment($data['equipment5'] ?? []);

        return $package->save();
    }

    public function getFixedDepartures()
    {
        return FixedDeparture::with('package')->ordered()->paginate(15);
    }

    public function addFixedDeparture(array $data): FixedDeparture
    {
        return FixedDeparture::create($data);
    }

    public function deleteFixedDeparture(int $id): bool
    {
        return FixedDeparture::findOrFail($id)->delete();
    }

    public function toggleDepartureStatus(int $id, string $status): bool
    {
        $dep = FixedDeparture::findOrFail($id);
        $dep->status = $status;
        return $dep->save();
    }

    
    protected function handleImages(array &$data, ?Package $package): void
    {
        foreach (['image', 'feature_image'] as $field) {
            if (isset($data[$field]) && $data[$field] instanceof UploadedFile) {
                if ($package && $package->{$field}) {
                    $this->mediaService->deleteImageVariants($package->{$field});
                }
                $data[$field] = $this->mediaService->uploadImage($data[$field], 'packages');
                $this->mediaService->dispatchImageProcessing($data[$field]); 
                
            } elseif (array_key_exists($field, $data) && $data[$field] === null) {
                if ($package && $package->{$field}) {
                    $this->mediaService->deleteImageVariants($package->{$field});
                }
                $data[$field] = null;
            } else {
                unset($data[$field]);
            }
        }
        
        if (isset($data['gallery']) && is_array($data['gallery'])) {
            $existingGallery = $package ? ($package->gallery ?? []) : [];
            foreach ($data['gallery'] as $file) {
                if ($file instanceof UploadedFile) {
                    $path = $this->mediaService->uploadImage($file, 'packages/gallery');
                    $existingGallery[] = $path;
                    $this->mediaService->dispatchImageProcessing($path);
                }
            }
            $data['gallery'] = $existingGallery;
        } else {
            unset($data['gallery']);
        }
    }


}