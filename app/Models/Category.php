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
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'parent_id', 'name', 'slug', 'excerpt', 'description', 'image', 'font_icon', 
    'order_level', 'display_on', 'meta_keywords', 'meta_description', 'status', 
    'created_by', 'updated_by'
])]
class Category extends Model
{
    use HasFactory, Slugable, HasImages, HasStatus, HasOrdering, Searchable;

    protected $table = 'categories';
    
    protected $appends = ['image_url'];

    protected array $searchableColumns = ['name'];

    protected function casts(): array 
    { 
        return [
            'status' => 'boolean', 
            'order_level' => 'integer',
        ]; 
    }

    public function parent(): BelongsTo 
    { 
        return $this->belongsTo(Category::class, 'parent_id'); 
    }

    public function children(): HasMany 
    { 
        return $this->hasMany(Category::class, 'parent_id')->ordered(); 
    }

    public function packages(): BelongsToMany 
    { 
        return $this->belongsToMany(Package::class, 'package_categories'); 
    }

    public function blogs(): BelongsToMany 
    { 
        return $this->belongsToMany(Blog::class, 'blog_category'); 
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
        $query = self::query()->with(['parent', 'creator']);
        
        if (isset($filters['status']) && $filters['status'] !== '') {
            $query->where('status', (bool) $filters['status']);
        }
        
        if (!empty($filters['parent_id'])) {
            $query->where('parent_id', $filters['parent_id']);
        }
        
        if (!empty($filters['display_on'])) {
            $query->where('display_on', $filters['display_on']);
        }
        
        if (!empty($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }
        
        return $query->ordered()->paginate(15)->appends($filters);
    }
}