<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasImages;
use App\Traits\Slugable;

#[Fillable([
    'parent_id', 'name', 'slug', 'excerpt', 'description', 'image', 
    'font_icon', 'order_level', 'display_on', 'meta_keywords', 
    'meta_description', 'status', 'created_by', 'updated_by',
])]
class Category extends Model
{
    use HasFactory, Slugable, HasImages;

    protected $table = 'categories';

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
            'order_level' => 'integer',
        ];
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')->orderBy('order_level');
    }

    public function creator()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }

  

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order_level', 'asc')->orderBy('name', 'asc');
    }

    public function getAllDescendantIds(): array
    {
        $categories = Category::select('id', 'parent_id')->get();
        $ids = [];
        $queue = [$this->id];

        while ($queue) {
            $parentId = array_shift($queue);
            foreach ($categories as $category) {
                if ((int) $category->parent_id === (int) $parentId) {
                    $ids[] = $category->id;
                    $queue[] = $category->id;
                }
            }
        }
        return $ids;
    }

    public static function getCategories($depth = 3) 
    {
        return self::with(['children' => function ($query) use ($depth) {
            if ($depth > 0) {
                $query->with(['children' => fn($q) => $q->with('children')->active()->ordered()])->active()->ordered();
            }
        }])
        ->whereNull('parent_id')
        ->select('id', 'parent_id', 'name', 'image', 'slug')
        ->active()
        ->ordered()
        ->get(); 
    }


    public static function getFilteredRecords(array $filters = [])
    {
        $query = self::query()->with(['parent', 'creator']);

        if (isset($filters['status']) && $filters['status'] !== '') {
            $query->where('status', filter_var($filters['status'], FILTER_VALIDATE_BOOLEAN));
        }

        if (isset($filters['parent_id']) && $filters['parent_id'] !== '') {
            $query->where('parent_id', $filters['parent_id']);
        }

        if (isset($filters['display_on']) && $filters['display_on'] !== '') {
            $query->where('display_on', $filters['display_on']);
        }

        if (!empty($filters['name'])) {
            $searchTerm = '%' . $filters['name'] . '%';
            $query->where('name', 'like', $searchTerm);
        }

        return $query->ordered()
                     ->paginate(15)
                     ->appends($filters); 
    }


}