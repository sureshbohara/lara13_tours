<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasImages;
use App\Traits\Slugable;

#[Fillable([
    'title',
    'subtitle',
    'icon',
    'short_content',
    'long_content',
    'slug',
    'image',
    'feature_image',
    'process_item',
    'highlight',
    'order_level',
    'status',
    'meta_keywords',
    'meta_description',
])]
class Service extends Model
{
    use HasFactory, Slugable, HasImages;

    protected $table = 'services';

    protected function casts(): array
    {
        return [
            'process_item'  => 'array',
            'highlight'     => 'array',
            'status'        => 'boolean',
            'order_level'   => 'integer',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order_level', 'asc')
                     ->orderBy('created_at', 'desc');
    }

    public function scopeSearch($query, string $term)
    {
        return $query->where('title', 'like', '%' . $term . '%')
                     ->orWhere('subtitle', 'like', '%' . $term . '%');
    }

    public static function getFilteredRecords(array $filters = [])
    {
        $query = self::query();

        if (array_key_exists('status', $filters) && $filters['status'] !== '') {
            $query->where('status', (int) $filters['status']);
        }

        if (!empty($filters['search'])) {
            $query->search($filters['search']);
        }

        return $query->ordered()->paginate(15)->appends($filters);
    }
}