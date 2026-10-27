<?php

declare(strict_types=1);

namespace App\Services\Admin;

use App\Models\Banner;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class BannerService
{
    public function __construct(
        protected Banner $model,
        protected MediaService $mediaService
    ) {}

    public function getItems(array $filters = [])
    {
        return $this->model::getFilteredRecords($filters);
    }



    public function store(array $data){
        return DB::transaction(function () use ($data) {
            if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
                $data['image'] = $this->mediaService->uploadImage($data['image'], 'banners');
                $this->mediaService->dispatchImageProcessing($data['image']);
            }
            return $this->model->create($data);
        });
    }


    public function update(int $id, array $data){
        return DB::transaction(function () use ($id, $data) {
            $item = $this->model->findOrFail($id);
            
            if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
                if ($item->image) $this->mediaService->deleteImageVariants($item->image);
                $data['image'] = $this->mediaService->uploadImage($data['image'], 'banners');
                $this->mediaService->dispatchImageProcessing($data['image']);
            } elseif (array_key_exists('image', $data) && $data['image'] === null) {
                if ($item->image) $this->mediaService->deleteImageVariants($item->image);
                $data['image'] = null;
            } else {
                unset($data['image']);
            }

            $item->update($data);
            return $item->fresh();
        });
    }


    public function delete(int $id): bool
    {
        $item = $this->model->findOrFail($id);
        if ($item->image) $this->mediaService->deleteImageVariants($item->image);
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