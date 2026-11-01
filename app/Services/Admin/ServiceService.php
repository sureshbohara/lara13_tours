<?php
declare(strict_types=1);
namespace App\Services\Admin;

use App\Models\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ServiceService extends BaseCrudService
{
    public function __construct(Service $model, MediaService $mediaService)
    {
        parent::__construct($model, $mediaService, 'services');
    }


    public function store(array $data): Service
    {
        return DB::transaction(function () use ($data) {
            $this->handleJsonFields($data);
            $this->handleImage($data, null, 'image');
            $this->handleImage($data, null, 'feature_image');
            return $this->model->create($data);
        });
    }


    public function update(int $id, array $data): Service
    {
        return DB::transaction(function () use ($id, $data) {
            $item = $this->model->findOrFail($id);
            $this->handleJsonFields($data);
            $this->handleImage($data, $item, 'image');
            $this->handleImage($data, $item, 'feature_image');
            $item->update($data);
            return $item->fresh();
        });
    }



    protected function deleteAssociatedImages(Model $item): void
    {
        parent::deleteAssociatedImages($item);
        if ($item->feature_image) {
            $this->mediaService->deleteImageVariants($item->feature_image);
        }
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
}