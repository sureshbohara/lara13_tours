<?php
declare(strict_types=1);

namespace App\Services\Admin;

use App\Models\ProductAttribute;
use Illuminate\Database\Eloquent\Model;

class ProductAttributeService extends BaseCrudService
{
    public function __construct(ProductAttribute $model, MediaService $mediaService)
    {
        parent::__construct($model, $mediaService, '');
    }

    public function storeAttribute(array $data): ProductAttribute
    {
        return $this->model->create($data);
    }

    public function updateAttribute(int $id, array $data): ProductAttribute
    {
        $attribute = $this->model->findOrFail($id);
        $attribute->update($data);
        return $attribute->fresh();
    }

    protected function deleteAssociatedImages(Model $item): void
    {
      
    }
}