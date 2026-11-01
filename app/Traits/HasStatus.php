<?php
namespace App\Traits;

trait HasStatus
{
    public function scopeActive($query){
        return $query->where('status', true);
    }

    public function scopeInactive($query){
        return $query->where('status', false);
    }
}