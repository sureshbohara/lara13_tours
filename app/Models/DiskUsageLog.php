<?php

declare(strict_types=1);

namespace App\Models;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
        'log_date',
        'used_bytes',
        'total_bytes',
    ])]

class DiskUsageLog extends Model
{
    protected $table = 'disk_usage_logs';



    protected function casts(): array
    {
        return [
            'log_date' => 'date',
            'used_bytes' => 'integer',
            'total_bytes' => 'integer',
        ];
    }
}