<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PackageCategory extends Model
{
    use HasFactory;

    protected $table = 'package_categories';

    protected $fillable = [
        'package_id',
        'category_id',
    ];

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}