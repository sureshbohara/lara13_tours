<?php

declare(strict_types=1);

namespace App\Services\Admin;

use App\Models\Category;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class CategoryService
{
    public function __construct(
        protected Category $model,
        protected MediaService $mediaService
    ) {}


    public function getCategories(array $filters = [])
    {
        return $this->model::getFilteredRecords($filters);
    }
    

    public function storeCategory(array $data){
        return DB::transaction(function () use ($data) {
            if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
                $data['image'] = $this->mediaService->uploadImage($data['image'], 'categories');
                $this->mediaService->dispatchImageProcessing($data['image']);
            }
            return $this->model->create($data);
        });
    }

    public function updateCategory(int $id, array $data){
        return DB::transaction(function () use ($id, $data) {
            $item = $this->model->findOrFail($id);
            
            if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
                if ($item->image) $this->mediaService->deleteImageVariants($item->image);
                $data['image'] = $this->mediaService->uploadImage($data['image'], 'categories');
                $this->mediaService->dispatchImageProcessing($data['image']);
            } elseif (array_key_exists('image', $data) && $data['image'] === null) {
                if ($item->image) $this->mediaService->deleteImageVariants($item->image);
                $data['image'] = null;
            } else {
                unset($data['image']);
            }

            $item->update($data);
            return $item->fresh(['parent']);
        });
    }

    public function deleteCategory(int $id): bool
    {
        $item = $this->model->findOrFail($id);

    
        if ($item->children()->exists()) {
            throw new \RuntimeException('Cannot delete category with child categories. Please delete or reassign children first.');
        }

    

        if ($item->image) {
            $this->mediaService->deleteImageVariants($item->image);
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
}