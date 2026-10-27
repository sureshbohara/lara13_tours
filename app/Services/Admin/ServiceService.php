<?php

declare(strict_types=1);

namespace App\Services\Admin;

use App\Models\Service;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class ServiceService
{
    public function __construct(
        protected Service $model,
        protected MediaService $mediaService
    ) {}

    public function getServices(array $filters = [])
    {
        return $this->model::getFilteredRecords($filters);
    }

    public function storeService(array $data)
    {
        return DB::transaction(function () use ($data) {
            $this->handleJsonFields($data);
            $this->handleImages($data, null);
            
            return $this->model->create($data);
        });
    }

    public function updateService(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $item = $this->model->findOrFail($id);
            
            $this->handleJsonFields($data);
            $this->handleImages($data, $item);
            
            $item->update($data);
            return $item->fresh();
        });
    }

    public function deleteService(int $id): bool
    {
        $item = $this->model->findOrFail($id);
        
        if ($item->image) {
            $this->mediaService->deleteImageVariants($item->image);
        }
        if ($item->feature_image) {
            $this->mediaService->deleteImageVariants($item->feature_image);
        }
        
        return $item->delete();
    }

    public function toggleStatus(int $id): bool
    {
        $item = $this->model->findOrFail($id);
        $item->status = !$item->status;
        $item->save();
        
        return $item->status;
    }

    public function updateOrderLevel(int $id, int $orderLevel): bool
    {
        return $this->model->findOrFail($id)->update(['order_level' => $orderLevel]);
    }

    protected function handleJsonFields(array &$data): void
    {
        foreach (['process_item', 'highlight'] as $field) {
            if (isset($data[$field]) && is_string($data[$field])) {
                $decoded = json_decode($data[$field], true);
                $data[$field] = is_array($decoded) ? $decoded : [];
            }
        }
    }

    protected function handleImages(array &$data, ?Service $item): void
    {
        foreach (['image', 'feature_image'] as $field) {
            if (isset($data[$field]) && $data[$field] instanceof UploadedFile) {
                if ($item && $item->{$field}) {
                    $this->mediaService->deleteImageVariants($item->{$field});
                }
                $data[$field] = $this->mediaService->uploadImage($data[$field], 'services');
                $this->mediaService->dispatchImageProcessing($data[$field]);
            } elseif (array_key_exists($field, $data) && $data[$field] === null) {
                if ($item && $item->{$field}) {
                    $this->mediaService->deleteImageVariants($item->{$field});
                }
                $data[$field] = null;
            } else {
                unset($data[$field]);
            }
        }
    }
}