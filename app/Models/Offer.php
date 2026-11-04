<?php
declare(strict_types=1);

namespace App\Models;

use App\Traits\HasStatus;
use App\Traits\Searchable;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'name', 'description', 'offer_type', 'buy_quantity', 'get_quantity',
    'discount_value', 'apply_on', 'product_ids', 'category_ids',
    'min_order_amount', 'max_uses', 'used_count', 'max_uses_per_user',
    'start_date', 'end_date', 'status', 'priority'
])]
class Offer extends Model
{
    use HasFactory, HasStatus, Searchable;

    protected $table = 'offers';
    protected array $searchableColumns = ['name', 'description'];

    protected function casts(): array
    {
        return [
            'discount_value' => 'decimal:2',
            'min_order_amount' => 'decimal:2',
            'buy_quantity' => 'integer',
            'get_quantity' => 'integer',
            'max_uses' => 'integer',
            'used_count' => 'integer',
            'max_uses_per_user' => 'integer',
            'product_ids' => 'array',
            'category_ids' => 'array',
            'start_date' => 'date',
            'end_date' => 'date',
            'status' => 'boolean',
            'priority' => 'integer',
        ];
    }

    public static function getFilteredRecords(array $filters = [])
    {
        return static::query()
            ->when(isset($filters['status']) && $filters['status'] !== '', fn ($q) => $q->where('status', (bool) $filters['status']))
            ->when(isset($filters['offer_type']) && $filters['offer_type'] !== '', fn ($q) => $q->where('offer_type', $filters['offer_type']))
            ->when(filled($filters['search'] ?? null), fn ($q) => $q->search($filters['search']))
            ->orderBy('priority', 'desc')
            ->latest()
            ->paginate(15)
            ->withQueryString();
    }
}