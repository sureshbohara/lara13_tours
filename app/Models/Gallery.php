<?php
declare(strict_types=1);

namespace App\Models;

use App\Traits\HasImages;
use App\Traits\HasStatus;
use App\Traits\HasOrdering;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'display_on', 'image', 'alt', 'order_level', 'status'])]
class Gallery extends Model
{
    use HasFactory, HasImages, HasStatus, HasOrdering, Searchable;

    protected $appends = ['image_url'];

    protected array $searchableColumns = ['name', 'alt'];

    protected function casts(): array 
    { 
        return ['status' => 'boolean', 'order_level' => 'integer']; 
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