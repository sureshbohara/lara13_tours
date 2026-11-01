<?php
declare(strict_types=1);
namespace App\Traits;

trait HasOrdering
{

    public function scopeOrdered($query){
        return $query->orderBy('order_level', 'asc')->orderByDesc('created_at');
    }
    
}