<?php

declare(strict_types=1);

namespace App\Services\Admin;

use App\Models\Faq;
use Illuminate\Support\Facades\DB;

class FaqService
{
    public function __construct(protected Faq $model) {}

    public function getItems(array $filters = [])
    {
        return $this->model::getFilteredRecords($filters);
    }

    public function store(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $item = $this->model->findOrFail($id);
        $item->update($data);
        
        return $item->fresh();
    }

    public function delete(int $id): bool
    {
        return $this->model->findOrFail($id)->delete();
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