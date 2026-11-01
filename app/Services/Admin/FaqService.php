<?php
declare(strict_types=1);

namespace App\Services\Admin;

use App\Models\Faq;
use Illuminate\Database\Eloquent\Model;

class FaqService extends BaseCrudService
{
    public function __construct(Faq $model, MediaService $mediaService)
    {
        parent::__construct($model, $mediaService, ''); 
    }

    public function store(array $data): Faq 
    { 
        return $this->model->create($data); 
    }

    public function update(int $id, array $data): Faq 
    {
        $item = $this->model->findOrFail($id);
        $item->update($data);
        return $item->fresh();
    }

    protected function deleteAssociatedImages(Model $item): void 
    {
        // Do nothing
    }

    
}