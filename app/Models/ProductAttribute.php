<?php
declare(strict_types=1);

namespace App\Models;

use App\Traits\HasStatus;
use App\Traits\HasOrdering;
use App\Traits\Searchable;
use App\Traits\Slugable;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'slug', 'type', 'values', 'order_level', 'status'])]
class ProductAttribute extends Model
{
    use HasFactory, Slugable, HasStatus, HasOrdering, Searchable;

    protected $table = 'product_attributes';
    
    protected array $searchableColumns = ['name'];

    protected function casts(): array
    {
        return [
            'values' => 'array',
            'status' => 'boolean',
            'order_level' => 'integer',
        ];
    }

    public static function getFilteredRecords(array $filters = [])
    {
        return static::query()
            ->when(isset($filters['status']) && $filters['status'] !== '', fn ($q) => $q->where('status', (bool) $filters['status']))
            ->when(filled($filters['search'] ?? null), fn ($q) => $q->search($filters['search']))
            ->ordered()
            ->paginate(15)
            ->withQueryString();
    }
}