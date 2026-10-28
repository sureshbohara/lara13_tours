<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HasImages;
use App\Traits\Slugable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'parent_id',
    'name',
    'slug',
    'excerpt',
    'description',
    'image',
    'font_icon',
    'order_level',
    'display_on',
    'meta_keywords',
    'meta_description',
    'status',
    'created_by',
    'updated_by',
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

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id')
            ->orderBy('order_level')
            ->orderBy('name');
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

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order_level')->orderBy('name');
    }

    public function getAllDescendantIds(): array
    {
        $categories = self::query()
            ->select('id', 'parent_id')
            ->get()
            ->groupBy('parent_id');

        $ids = [];
        $queue = [$this->id];

        while (!empty($queue)) {
            $parentId = array_shift($queue);

            foreach ($categories->get($parentId, collect()) as $category) {
                $ids[] = $category->id;
                $queue[] = $category->id;
            }
        }

        return $ids;
    }

    public static function getCategories(int $depth = 3)
    {
        $query = self::query()
            ->whereNull('parent_id')
            ->select('id', 'parent_id', 'name', 'image', 'slug')
            ->active()
            ->ordered();

        if ($depth > 0) {
            $query->with([
                'children' => function ($query) use ($depth) {
                    $query->active()
                        ->ordered()
                        ->select(
                            'id',
                            'parent_id',
                            'name',
                            'image',
                            'slug'
                        );

                    if ($depth > 1) {
                        $query->with(
                            self::childrenWithDepth($depth - 1)
                        );
                    }
                },
            ]);
        }

        return $query->get();
    }

    private static function childrenWithDepth(int $depth): array
    {
        return [
            'children' => function ($query) use ($depth) {
                $query->active()
                    ->ordered()
                    ->select(
                        'id',
                        'parent_id',
                        'name',
                        'image',
                        'slug'
                    );

                if ($depth > 1) {
                    $query->with(
                        self::childrenWithDepth($depth - 1)
                    );
                }
            },
        ];
    }

    public static function getFilteredRecords(array $filters = [])
    {
        $query = self::query()->with([
            'parent',
            'creator',
        ]);

        if (isset($filters['status']) && $filters['status'] !== '') {
            $query->where(
                'status',
                filter_var(
                    $filters['status'],
                    FILTER_VALIDATE_BOOLEAN
                )
            );
        }

        if (isset($filters['parent_id']) && $filters['parent_id'] !== '') {
            $query->where('parent_id', $filters['parent_id']);
        }

        if (isset($filters['display_on']) && $filters['display_on'] !== '') {
            $query->where('display_on', $filters['display_on']);
        }

        if (!empty($filters['name'])) {
            $query->where(
                'name',
                'like',
                '%' . $filters['name'] . '%'
            );
        }

        return $query->ordered()
            ->paginate(15)
            ->appends($filters);
    }
}