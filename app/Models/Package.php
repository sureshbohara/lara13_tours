<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasImages;
use App\Traits\Slugable;

#[Fillable([
    'name', 'slug', 'image', 'feature_image', 'gallery', 'map',
    'trip_previous_price', 'trip_price', 'group_size_price',
    'excerpt', 'description', 'content', 'highlight_key',
    'included_data', 'excluded_data', 'faqs', 'itinerary_data',
    'general', 'lower_body', 'upper_body', 'footwear', 'accessories', 'activities',
    'duration', 'transportation', 'trip_grading', 'max_altitude', 'accommodation', 'meals', 'best_season',
    'view_count', 'status', 'order_level', 'display_on',
    'meta_title', 'meta_keywords', 'meta_description','created_by', 'updated_by',
])]
class Package extends Model
{
    use HasFactory, Slugable, HasImages;

    protected $table = 'packages';

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

    public function categories() {
        return $this->belongsToMany(Category::class, 'package_categories');
    }

    public function fixedDepartures() {
        return $this->hasMany(FixedDeparture::class);
    }

    public function scopeActive($query) {
        return $query->where('status', true);
    }

    public function scopeOrdered($query) {
        return $query->orderBy('order_level', 'asc')->orderBy('created_at', 'desc');
    }


      public function creator()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }

    public static function getFilteredRecords(array $filters = []) {
        $query = self::query()->with('categories');
        if (isset($filters['status']) && $filters['status'] !== '') {
            $query->where('status', (int) $filters['status']);
        }
        if (!empty($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }
        return $query->ordered()->paginate(15)->appends($filters);
    }
}