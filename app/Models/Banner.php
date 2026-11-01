<?php
declare(strict_types=1);

namespace App\Models;


use App\Traits\HasImages;
use App\Traits\HasStatus;
use App\Traits\HasOrdering;
use App\Traits\Searchable;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'subtitle', 'image', 'description', 'order_level', 'status'])]
class Banner extends Model
{
    use HasFactory, HasImages, HasStatus, HasOrdering, Searchable;

    protected $appends = ['image_url'];
    protected array $searchableColumns = ['title', 'subtitle'];

    protected function casts(): array 
    { 
        return ['status' => 'boolean', 'order_level' => 'integer']; 
    }

    public static function getFilteredRecords(array $filters = [])
    {
        return static::query()
            ->when(isset($filters['status']) && $filters['status'] !== '', fn ($q) => $q->where('status', (bool) $filters['status']))
            ->when(filled($filters['search'] ?? null), fn ($q) => $q->search($filters['search']))
            ->ordered()->paginate(15)->withQueryString();
    }
}