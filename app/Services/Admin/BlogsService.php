<?php

declare(strict_types=1);

namespace App\Services\Admin;

use App\Models\Blog;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BlogsService
{
    public function __construct(
        protected Blog $model,
        protected MediaService $mediaService
    ) {}

    public function getBlogs(array $filters = [])
    {
        return $this->model::getFilteredRecords($filters);
    }

    public function storeBlog(array $data)
    {
        return DB::transaction(function () use ($data) {
            $categoryIds = $data['category_ids'] ?? [];
            unset($data['category_ids']);

            if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
                $data['image'] = $this->mediaService->uploadImage($data['image'], 'blogs');
                $this->mediaService->dispatchImageProcessing($data['image']);
            }

            $adminId = Auth::guard('admin')->id();
            $data['created_by'] = $adminId;
            $data['updated_by'] = $adminId;

            $blog = $this->model->create($data);
            $blog->categories()->sync($categoryIds); 

            return $blog->fresh(['categories', 'creator']);
        });
    }

    public function updateBlog(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $blog = $this->model->findOrFail($id);
            $categoryIds = $data['category_ids'] ?? [];
            unset($data['category_ids']);

            if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
                if ($blog->image) $this->mediaService->deleteImageVariants($blog->image);
                $data['image'] = $this->mediaService->uploadImage($data['image'], 'blogs');
                $this->mediaService->dispatchImageProcessing($data['image']);
            } elseif (array_key_exists('image', $data) && $data['image'] === null) {
                if ($blog->image) $this->mediaService->deleteImageVariants($blog->image);
                $data['image'] = null;
            } else {
                unset($data['image']);
            }

            $data['updated_by'] = Auth::guard('admin')->id();

            $blog->update($data);
            $blog->categories()->sync($categoryIds); 

            return $blog->fresh(['categories', 'creator']);
        });
    }

    public function deleteBlog(int $id): bool
    {
        $blog = $this->model->findOrFail($id);
        if ($blog->image) {
            $this->mediaService->deleteImageVariants($blog->image);
        }
        return $blog->delete();
    }

    public function toggleStatus(int $id): bool
    {
        $blog = $this->model->findOrFail($id);
        $blog->status = !$blog->status;
        $blog->save();
        return $blog->status;
    }

    public function updateOrderLevel(int $id, int $orderLevel): bool
    {
        return $this->model->findOrFail($id)->update(['order_level' => $orderLevel]);
    }
}