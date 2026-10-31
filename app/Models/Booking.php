<?php

declare(strict_types=1);

namespace App\Models;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
        'package_id',
        'fixed_departure_id',
        'name',
        'email',
        'phone',
        'number_of_people',
        'travel_date',
        'message',
        'status',
])]

class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings';

    protected $casts = [
        'travel_date' => 'date',
        'number_of_people' => 'integer',
    ];

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function fixedDeparture(): BelongsTo
    {
        return $this->belongsTo(FixedDeparture::class);
    }
}