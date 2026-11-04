<?php
declare(strict_types=1);

namespace App\Models;

use App\Traits\HasImages;
use App\Traits\HasStatus;
use App\Traits\HasOrdering;
use App\Traits\Searchable;
use App\Traits\Slugable;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'slug', 'logo', 'description', 'website', 'order_level', 'status', 'meta_title', 'meta_description'])]
class Brand extends Model
{
    use HasFactory, Slugable, HasImages, HasStatus, HasOrdering, Searchable;

    protected $table = 'brands';
    protected $appends = ['logo_url'];
    
    protected array $searchableColumns = ['name', 'description'];

    protected function casts(): array
    {
        return [
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