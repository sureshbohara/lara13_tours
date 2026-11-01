<?php
declare(strict_types=1);

namespace App\Services\Admin;

use App\Models\Gallery;
use Illuminate\Support\Facades\DB;

class GalleryService extends BaseCrudService
{
    public function __construct(Gallery $model, MediaService $mediaService)
    {
        parent::__construct($model, $mediaService, 'galleries');
    }

    public function getItems(array $filters = [])
    {
        return $this->model::getFilteredRecords($filters);
    }

    public function store(array $data): Gallery
    {
        return DB::transaction(function () use ($data) {
            $this->handleImage($data, null, 'image');
            return $this->model->create($data);
        });
    }

    public function update(int $id, array $data): Gallery
    {
        return DB::transaction(function () use ($id, $data) {
            $item = $this->model->findOrFail($id);
            $this->handleImage($data, $item, 'image');
            
            $item->update($data);
            return $item->fresh();
        });
    }


}