<?php
declare(strict_types=1);

namespace App\Services\Admin;

use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryService extends BaseCrudService
{
    public function __construct(Category $model, MediaService $mediaService)
    {
        parent::__construct($model, $mediaService, 'categories');
    }

    public function getCategories(array $filters = [])
    {
        return $this->model::getFilteredRecords($filters);
    }

    public function storeCategory(array $data): Category
    {
        return DB::transaction(function () use ($data) {
            $this->handleImage($data, null, 'image');
            return $this->model->create($data);
        });
    }

    public function updateCategory(int $id, array $data): Category
    {
        return DB::transaction(function () use ($id, $data) {
            $item = $this->model->findOrFail($id);
            $this->handleImage($data, $item, 'image');
            
            $item->update($data);
            return $item->fresh(['parent']);
        });
    }

    public function delete(int $id): bool
    {
        $item = $this->model->findOrFail($id);

        if ($item->children()->exists()) {
            throw new \RuntimeException('Cannot delete category with child categories. Please delete or reassign children first.');
        }

        return parent::delete($id);
    }

  
}