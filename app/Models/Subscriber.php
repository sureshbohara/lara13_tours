<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['email', 'status', 'subscribed_at', 'unsubscribed_at'])]
class Subscriber extends Model
{
    protected $table = 'subscribers';

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
            'subscribed_at' => 'datetime',
            'unsubscribed_at' => 'datetime',
        ];
    }

    public function scopeActive($query){
        return $query->where('status', true);
    }

    public static function getFilteredRecords(array $filters = []){
        $query = self::query();

        if (array_key_exists('status', $filters) && $filters['status'] !== '') {
            $query->where('status', (int) $filters['status']);
        }

        if (!empty($filters['search'])) {
            $query->where('email', 'like', '%' . $filters['search'] . '%');
        }

        return $query->latest()->paginate(15)->appends($filters);
    }
}