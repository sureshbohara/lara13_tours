<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasImages;

  #[Fillable([
        'name',
        'display_on',
        'image',
        'alt',
        'order_level',
        'status',
    ])]
class Gallery extends Model
{
    use HasFactory, HasImages;

  
    protected function casts(): array
    {
        return [
            'status' => 'boolean',
            'order_level' => 'integer',
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
        return $query->where('name', 'like', '%' . $term . '%')
                     ->orWhere('alt', 'like', '%' . $term . '%');
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