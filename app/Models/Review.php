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

#[Fillable(['name', 'email', 'address', 'rating', 'review', 'content', 'image', 'display_on', 'order_level', 'status'])]
class Review extends Model
{
    use HasFactory, HasImages, HasStatus, HasOrdering, Searchable;

    protected $appends = ['image_url'];

    protected array $searchableColumns = ['name', 'review'];
    
    protected function casts(): array 
    { 
        return [
            'rating' => 'integer', 
            'order_level' => 'integer', 
            'status' => 'boolean'
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