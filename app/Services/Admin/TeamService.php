<?php
declare(strict_types=1);

namespace App\Services\Admin;

use App\Models\Team;
use Illuminate\Support\Facades\DB;

class TeamService extends BaseCrudService
{
    public function __construct(Team $model, MediaService $mediaService)
    {
        parent::__construct($model, $mediaService, 'teams');
    }

    public function getItems(array $filters = [])
    {
        return $this->model::getFilteredRecords($filters);
    }

    public function store(array $data): Team
    {
        return DB::transaction(function () use ($data) {
            $this->handleImage($data, null, 'image');
            return $this->model->create($data);
        });
    }

    public function update(int $id, array $data): Team
    {
        return DB::transaction(function () use ($id, $data) {
            $item = $this->model->findOrFail($id);
            $this->handleImage($data, $item, 'image');
            
            $item->update($data);
            return $item->fresh();
        });
    }

   
}