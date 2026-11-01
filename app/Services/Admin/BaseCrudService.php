<?php
declare(strict_types=1);

namespace App\Services\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

abstract class BaseCrudService
{
    protected Model $model;
    protected MediaService $mediaService;
    protected string $imageDirectory;

    public function __construct(Model $model, MediaService $mediaService, string $imageDirectory = '')
    {
        $this->model = $model;
        $this->mediaService = $mediaService;
        $this->imageDirectory = $imageDirectory;
    }

    public function getItems(array $filters = [])
    {
        return $this->model::getFilteredRecords($filters);
    }

    public function toggleStatus(int $id): bool
    {
        $item = $this->model->findOrFail($id);
        $item->status = !$item->status;
        $item->save();
        return (bool) $item->status;
    }

    public function updateOrderLevel(int $id, int $orderLevel): bool
    {
        return $this->model->findOrFail($id)->update(['order_level' => $orderLevel]);
    }

    public function delete(int $id): bool
    {
        $item = $this->model->findOrFail($id);
        $this->deleteAssociatedImages($item);
        return $item->delete();
    }


    protected function deleteAssociatedImages(Model $item): void
    {
        if (isset($item->image) && $item->image) {
            $this->mediaService->deleteImageVariants($item->image);
        }
    }

   
    protected function handleImage(array &$data, ?Model $item, string $field = 'image'): void
    {
        if (isset($data[$field]) && $data[$field] instanceof UploadedFile) {
            if ($item && $item->{$field}) {
                $this->mediaService->deleteImageVariants($item->{$field});
            }
            $data[$field] = $this->mediaService->uploadImage($data[$field], $this->imageDirectory);
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