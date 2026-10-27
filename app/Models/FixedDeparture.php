<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'package_id', 'start_date', 'end_date', 'discount_price', 
    'max_seats', 'booked_seats', 'description', 'status'
])]
class FixedDeparture extends Model
{
    use HasFactory;

    protected $table = 'fixed_departures';

    protected function casts(): array 
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'max_seats' => 'integer',
            'booked_seats' => 'integer',
        ];
    }

    public function package() {
        return $this->belongsTo(Package::class);
    }

      public function scopeOrdered($query){
        return $query->orderBy('start_date', 'asc');
    }
}