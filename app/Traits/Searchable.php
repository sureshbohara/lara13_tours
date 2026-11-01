<?php
declare(strict_types=1);
namespace App\Traits;

trait Searchable
{

    public function scopeSearch($query, string $term){
        if (property_exists($this, 'searchableColumns') && !empty($this->searchableColumns)) {
            return $query->where(function ($q) use ($term) {
                foreach ($this->searchableColumns as $column) {
                    $q->orWhere($column, 'like', "%{$term}%");
                }
            });
        }
        return $query;
    }
    
}