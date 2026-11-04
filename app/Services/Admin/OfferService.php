<?php
declare(strict_types=1);

namespace App\Services\Admin;

use App\Models\Offer;
use Illuminate\Database\Eloquent\Model;

class OfferService extends BaseCrudService
{
    public function __construct(Offer $model, MediaService $mediaService)
    {
        parent::__construct($model, $mediaService, '');
    }

    public function storeOffer(array $data): Offer
    {
        $data['product_ids'] = $this->formatArray($data['product_ids'] ?? null);
        $data['category_ids'] = $this->formatArray($data['category_ids'] ?? null);
        return $this->model->create($data);
    }

    public function updateOffer(int $id, array $data): Offer
    {
        $offer = $this->model->findOrFail($id);
        $data['product_ids'] = $this->formatArray($data['product_ids'] ?? null);
        $data['category_ids'] = $this->formatArray($data['category_ids'] ?? null);
        $offer->update($data);
        return $offer->fresh();
    }

    protected function deleteAssociatedImages(Model $item): void
    {
        // No images to delete
    }

    private function formatArray(mixed $data): ?array
    {
        if (is_array($data)) {
            $data = array_filter($data);
            return empty($data) ? null : array_values($data);
        }
        return null;
    }
}