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
    'title', 'subtitle', 'icon', 'short_content', 'long_content', 'slug', 
    'image', 'feature_image', 'process_item', 'highlight', 'order_level', 
    'status', 'meta_keywords', 'meta_description'
])]
class Service extends Model
{
    use HasFactory, Slugable, HasImages, HasStatus, HasOrdering, Searchable;

    protected array $searchableColumns = ['title', 'subtitle'];

    protected function casts(): array 
    { 
        return [
            'process_item' => 'array', 
            'highlight' => 'array', 
            'status' => 'boolean', 
            'order_level' => 'integer'
        ]; 
    }

    public static function getFilteredRecords(array $filters = []) 
    {
        return self::query()
            ->when(isset($filters['status']) && $filters['status'] !== '', fn($q) => $q->where('status', (int) $filters['status']))
            ->when(!empty($filters['search']), fn($q) => $q->search($filters['search']))
            ->ordered()->paginate(15)->appends($filters);
    }
}