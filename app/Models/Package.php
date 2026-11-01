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
    'name', 'slug', 'image', 'feature_image', 'gallery', 'map',
    'trip_previous_price', 'trip_price', 'group_size_price',
    'excerpt', 'description', 'content', 'highlight_key',
    'included_data', 'excluded_data', 'faqs', 'itinerary_data',
    'general', 'lower_body', 'upper_body', 'footwear', 'accessories', 'activities',
    'duration', 'transportation', 'trip_grading', 'max_altitude', 'accommodation', 'meals', 'best_season',
    'view_count', 'status', 'order_level', 'display_on',
    'meta_title', 'meta_keywords', 'meta_description', 'created_by', 'updated_by',
])]
class Package extends Model
{
    use HasFactory, Slugable, HasImages, HasStatus, HasOrdering, Searchable;

    protected $table = 'packages';
    protected $appends = ['image_url', 'feature_image_url'];

    protected array $searchableColumns = ['name', 'excerpt', 'description'];

    protected function casts(): array
    {
        return [
            'gallery' => 'array',
            'group_size_price' => 'array',
            'highlight_key'    => 'array',
            'included_data'    => 'array',
            'excluded_data'    => 'array',
            'faqs'             => 'array',
            'itinerary_data'   => 'array',
            'general'          => 'array',
            'lower_body'       => 'array',
            'upper_body'       => 'array',
            'footwear'         => 'array',
            'accessories'      => 'array',
            'activities'       => 'array',
            'view_count'       => 'integer',
            'status'           => 'boolean',
            'order_level'      => 'integer',
        ];
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'package_categories');
    }

    public function fixedDepartures(): HasMany
    {
        return $this->hasMany(FixedDeparture::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(PackageReview::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
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
        $query = self::query()->with('categories');

        if (isset($filters['status']) && $filters['status'] !== '') {
            $query->where('status', (int) $filters['status']);
        }

        if (!empty($filters['search'] ?? $filters['name'] ?? null)) {
            $query->search($filters['search'] ?? $filters['name']);
        }

        return $query->ordered()->paginate(15)->appends($filters);
    }
}