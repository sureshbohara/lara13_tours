<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Traits\HasImages;
use App\Traits\Slugable;

#[Fillable([
    'title', 'slug', 'image', 'excerpt', 'description',
    'meta_title', 'meta_description', 'views', 'is_featured', 
    'status', 'order_level', 'created_by', 'updated_by'
])]
class Blog extends Model
{
    use HasFactory, Slugable, HasImages;

    protected $table = 'blogs';

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'status' => 'boolean',
            'views' => 'integer',
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

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order_level', 'asc')->orderBy('created_at', 'desc');
    }

    public static function getFilteredRecords(array $filters = [])
    {
        $query = self::query()->with(['categories', 'creator']);

        if (isset($filters['status']) && $filters['status'] !== '') {
            $query->where('status', (int) $filters['status']);
        }

        if (isset($filters['category_id']) && $filters['category_id'] !== '') {
            $query->whereHas('categories', function ($q) use ($filters) {
                $q->where('categories.id', $filters['category_id']);
            });
        }

        if (!empty($filters['search'])) {
            $searchTerm = '%' . $filters['search'] . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', $searchTerm)
                  ->orWhere('excerpt', 'like', $searchTerm)
                  ->orWhere('description', 'like', $searchTerm);
            });
        }

        return $query->ordered()->paginate(15)->appends($filters);
    }
}