<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
#[Fillable(['role_id', 'permissions'])]
class Permission extends Model
{
   
    protected function casts(): array
    {
        return [
            'permissions' => 'array',
        ];
    }

  
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

 
    public function hasPermission(string $entity, string $action): bool
    {
        return ($this->permissions[$entity][$action] ?? '0') === '1';
    }


    public function grantAll(string $entity): void
    {
        $permissions = $this->permissions ?? [];

        foreach (['read', 'create', 'update', 'delete'] as $action) {
            $permissions[$entity][$action] = '1';
        }

        $this->permissions = $permissions;
    }

    public function revokeAll(string $entity): void
    {
        $permissions = $this->permissions ?? [];

        foreach (['read', 'create', 'update', 'delete'] as $action) {
            $permissions[$entity][$action] = '0';
        }

        $this->permissions = $permissions;
    }

    public function clearAdminCache(): void
    {
        // Cache clear logic here if needed
    }
}