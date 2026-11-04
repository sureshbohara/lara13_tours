<?php
declare(strict_types=1);

namespace App\Services\Admin;

use App\Models\Brand;
use Illuminate\Support\Facades\DB;

class BrandService extends BaseCrudService
{
    public function __construct(Brand $model, MediaService $mediaService)
    {
        parent::__construct($model, $mediaService, 'brands');
    }

    public function storeBrand(array $data): Brand
    {
        return DB::transaction(function () use ($data) {
            $this->handleImage($data, null, 'logo');
            return $this->model->create($data);
        });
    }

    public function updateBrand(int $id, array $data): Brand
    {
        return DB::transaction(function () use ($id, $data) {
            $brand = $this->model->findOrFail($id);
            $this->handleImage($data, $brand, 'logo');
            $brand->update($data);
            return $brand->fresh();
        });
    }
}