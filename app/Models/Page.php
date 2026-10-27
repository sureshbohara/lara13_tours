<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasImages;
use App\Traits\Slugable;


    #[Fillable([
        'title', 'slug', 'icon', 'image', 'short_content', 'content',
        'meta_title', 'meta_description', 'meta_keywords',
        'show_in_menu', 'show_in_footer', 'is_featured', 'order_level', 'status',
    ])]
class Page extends Model
{
    use HasFactory, Slugable, HasImages;

    protected function casts(): array
    {
        return [
            'status'         => 'boolean',
            'show_in_menu'   => 'boolean',
            'show_in_footer' => 'boolean',
            'is_featured'    => 'boolean',
            'order_level'    => 'integer',
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
                     ->orWhere('content', 'like', '%' . $term . '%');
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