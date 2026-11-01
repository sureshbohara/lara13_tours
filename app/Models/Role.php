<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'display_name', 'description', 'status'])]
class Role extends Model
{
    use HasFactory;

   
    protected function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }

    public function admins()
    {
        return $this->hasMany(Admin::class, 'role_id');
    }

  
    public function permission()
    {
        return $this->hasOne(Permission::class, 'role_id');
    }

    public function isSuperAdmin(): bool
    {
        return $this->name === 'super_admin';
    }


    public function canDelete(): bool
    {
        return !$this->isSuperAdmin() && !$this->admins()->exists();
    }

  
    public function getPermissionsArray(): array
    {
        return $this->permission?->permissions ?? [];
    }


    public function hasPermission(string $entity, string $action): bool
    {
        return ($this->getPermissionsArray()[$entity][$action] ?? '0') === '1';
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}