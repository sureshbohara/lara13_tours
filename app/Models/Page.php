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

#[Fillable([
    'title', 'slug', 'icon', 'image', 'short_content', 'content', 
    'meta_title', 'meta_description', 'meta_keywords', 'show_in_menu', 
    'show_in_footer', 'is_featured', 'order_level', 'status'
])]
class Page extends Model
{
    use HasFactory, Slugable, HasImages, HasStatus, HasOrdering, Searchable;

  
    protected array $searchableColumns = ['title', 'content'];

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

    public static function getFilteredRecords(array $filters = []) 
    {
        return self::query()
            ->when(isset($filters['status']) && $filters['status'] !== '', fn($q) => $q->where('status', (int) $filters['status']))
            ->when(!empty($filters['search']), fn($q) => $q->search($filters['search']))
            ->ordered()
            ->paginate(15)
            ->appends($filters);
    }
}