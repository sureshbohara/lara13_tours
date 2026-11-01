<?php
declare(strict_types=1);

namespace App\Models;

use App\Traits\HasImages;
use App\Traits\HasStatus;
use App\Traits\HasOrdering;
use App\Traits\Searchable;
use App\Traits\Slugable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable([
    'title', 'slug', 'image', 'excerpt', 'description', 'meta_title', 
    'meta_description', 'views', 'is_featured', 'status', 'order_level', 
    'created_by', 'updated_by',
])]
class Blog extends Model
{
    use HasFactory, Slugable, HasImages, HasStatus, HasOrdering, Searchable;

    protected $table = 'blogs';
    protected $appends = ['image_url'];
    
 
    protected array $searchableColumns = ['title', 'excerpt', 'description'];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'status'      => 'boolean',
            'views'       => 'integer',
            'order_level' => 'integer',
        ];
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'blog_category');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }

    public static function getFilteredRecords(array $filters = [])
    {
        return static::query()
            ->with(['categories', 'creator'])
            ->when(isset($filters['status']) && $filters['status'] !== '', fn ($q) => $q->where('status', (bool) $filters['status']))
            ->when(isset($filters['category_id']) && $filters['category_id'] !== '', fn ($q) => $q->whereHas('categories', fn ($q2) => $q2->where('categories.id', $filters['category_id'])))
            ->when(filled($filters['search'] ?? null), fn ($q) => $q->search($filters['search'])) // Uses Searchable trait
            ->ordered() 
            ->paginate(15)
            ->withQueryString();
    }
}