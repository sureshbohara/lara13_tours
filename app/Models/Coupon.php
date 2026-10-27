<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'code', 'type', 'value', 'min_order_amount', 'max_discount',
    'usage_limit', 'used_count', 'per_user_limit',
    'start_date', 'end_date', 'applicable_packages',
    'description', 'status', 'created_by', 'updated_by'
])]
class Coupon extends Model
{
    use HasFactory;

    protected $table = 'coupons';

    protected function casts(): array
    {
        return [
            'value' => 'decimal:2',
            'min_order_amount' => 'decimal:2',
            'max_discount' => 'decimal:2',
            'usage_limit' => 'integer',
            'used_count' => 'integer',
            'per_user_limit' => 'integer',
            'start_date' => 'datetime',
            'end_date' => 'datetime',
            'applicable_packages' => 'array',
            'status' => 'boolean',
        ];
    }

    // Relationships
    public function creator(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', true)
                     ->where('start_date', '<=', now())
                     ->where(function ($q) {
                         $q->whereNull('end_date')
                           ->orWhere('end_date', '>=', now());
                     });
    }

    public function scopeValid($query)
    {
        return $query->active()
                     ->where(function ($q) {
                         $q->whereNull('usage_limit')
                           ->orWhereColumn('used_count', '<', 'usage_limit');
                     });
    }

    // Accessors
    public function getFormattedValueAttribute(): string
    {
        return $this->type === 'percentage' 
            ? $this->value . '%' 
            : '$' . number_format($this->value, 2);
    }

    public function getIsValidAttribute(): bool
    {
        return $this->status 
            && $this->start_date <= now()
            && ($this->end_date === null || $this->end_date >= now())
            && ($this->usage_limit === null || $this->used_count < $this->usage_limit);
    }

    // Filter Method
    public static function getFilteredRecords(array $filters = [])
    {
        $query = self::query();

        if (isset($filters['status']) && $filters['status'] !== '') {
            $query->where('status', (int) $filters['status']);
        }

        if (isset($filters['type']) && $filters['type'] !== '') {
            $query->where('type', $filters['type']);
        }

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('code', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('description', 'like', '%' . $filters['search'] . '%');
            });
        }

        return $query->latest()->paginate(15)->appends($filters);
    }
}