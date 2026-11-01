<?php
declare(strict_types=1);
namespace App\Services\Admin;

use App\Models\Banner;
use Illuminate\Support\Facades\DB;

class BannerService extends BaseCrudService
{
    public function __construct(Banner $model, MediaService $mediaService)
    {
        parent::__construct($model, $mediaService, 'banners');
    }

    public function store(array $data): Banner
    {
        return DB::transaction(function () use ($data) {
            $this->handleImage($data, null);
            return $this->model->create($data);
        });
    }

    public function update(int $id, array $data): Banner
    {
        return DB::transaction(function () use ($id, $data) {
            $banner = $this->model->findOrFail($id);
            $this->handleImage($data, $banner);
            $banner->update($data);
            return $banner->fresh();
        });
    }
}