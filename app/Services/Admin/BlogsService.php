<?php
declare(strict_types=1);

namespace App\Services\Admin;

use App\Models\Blog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BlogsService extends BaseCrudService
{
    public function __construct(Blog $model, MediaService $mediaService)
    {
        parent::__construct($model, $mediaService, 'blogs');
    }

    public function getBlogs(array $filters = [])
    {
        return $this->model::getFilteredRecords($filters);
    }

    public function store(array $data): Blog
    {
        return DB::transaction(function () use ($data) {
            $categoryIds = $data['category_ids'] ?? [];
            unset($data['category_ids']);

            $adminId = Auth::guard('admin')->id();
            $data['created_by'] = $adminId;
            $data['updated_by'] = $adminId;
            $this->handleImage($data, null, 'image');

            $blog = $this->model->create($data);
            $blog->categories()->sync($categoryIds);

            return $blog->fresh(['categories', 'creator']);
        });
    }

    public function update(int $id, array $data): Blog
    {
        return DB::transaction(function () use ($id, $data) {
            $blog = $this->model->findOrFail($id);
            
            $categoryIds = $data['category_ids'] ?? [];
            unset($data['category_ids']);

            $data['updated_by'] = Auth::guard('admin')->id();
            $this->handleImage($data, $blog, 'image');

            $blog->update($data);
            $blog->categories()->sync($categoryIds);

            return $blog->fresh(['categories', 'creator']);
        });
    }

}