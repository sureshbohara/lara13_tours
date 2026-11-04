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
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'brand_id', 'category_id', 'name', 'slug', 'sku', 'barcode', 'product_type',
    'regular_price', 'sale_price', 'sale_price_start', 'sale_price_end',
    'manage_stock', 'stock_quantity', 'stock_status', 'low_stock_threshold',
    'short_description', 'description', 'tags', 'image', 'gallery',
    'video_url', 'faqs', 'downloadable_file', 'download_limit', 'download_expiry_days',
    'is_featured', 'is_virtual', 'view_count', 'order_level', 'status',
    'meta_title', 'meta_description'
])]
class Product extends Model
{
    use HasFactory, Slugable, HasImages, HasStatus, HasOrdering, Searchable;

    protected $table = 'products';

    protected $appends = ['image_url'];

    protected array $searchableColumns = ['name', 'sku', 'description'];

    protected function casts(): array
    {
        return [
            'regular_price' => 'decimal:2',
            'sale_price' => 'decimal:2',
            'sale_price_start' => 'date',
            'sale_price_end' => 'date',
            'manage_stock' => 'boolean',
            'stock_quantity' => 'integer',
            'low_stock_threshold' => 'integer',
            'tags' => 'array',
            'gallery' => 'array',
            'faqs' => 'array',
            'download_limit' => 'integer',
            'download_expiry_days' => 'integer',
            'is_featured' => 'boolean',
            'is_virtual' => 'boolean',
            'view_count' => 'integer',
            'status' => 'boolean',
            'order_level' => 'integer',
        ];
    }

  

    public function brand(): BelongsTo { return $this->belongsTo(Brand::class); }


    public function category(): BelongsTo { return $this->belongsTo(Category::class); }


    public function variants(): HasMany { return $this->hasMany(ProductVariant::class); }


    public function bundles(): HasMany { return $this->hasMany(ProductBundle::class, 'parent_product_id'); }



    public static function getFilteredRecords(array $filters = [])
    {
        return static::query()->with(['brand', 'category'])
            ->when(isset($filters['status']) && $filters['status'] !== '', fn ($q) => $q->where('status', (bool) $filters['status']))
            ->when(isset($filters['product_type']) && $filters['product_type'] !== '', fn ($q) => $q->where('product_type', $filters['product_type']))
            ->when(isset($filters['brand_id']) && $filters['brand_id'] !== '', fn ($q) => $q->where('brand_id', $filters['brand_id']))
            ->when(filled($filters['search'] ?? null), fn ($q) => $q->search($filters['search']))
            ->ordered()
            ->paginate(15)
            ->withQueryString();
    }
    
}