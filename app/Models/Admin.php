<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\HasImages;

#[Fillable([
    'name', 'email', 'password', 'role_id', 'mobile', 'address', 
    'gender', 'image', 'details', 'status', 'order_level', 'last_login_at',
])]
#[Hidden(['password', 'remember_token'])]
class Admin extends Authenticatable
{
    use HasFactory, Notifiable, HasImages;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
            'status' => 'boolean',
            'order_level' => 'integer',
        ];
    }

    public function role(){
        return $this->belongsTo(Role::class);
    }

    public function permissionRecord(){
        return $this->hasOne(Permission::class, 'role_id', 'role_id');
    }

    public function isSuperAdmin(): bool
    {
        return $this->role?->name === 'super_admin';
    }

    public function hasPermission(string $entity, string $action): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }
        return $this->permissionRecord?->hasPermission($entity, $action) ?? false;
    }

    public function canDo(string $ability): bool
    {
        if (!str_contains($ability, '.')) {
            return false;
        }
        [$entity, $action] = explode('.', $ability, 2);
        return $this->hasPermission($entity, $action);
    }

    // ==========================================
    //  Eloquent Scopes & Static Method
    // ==========================================

 
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

 
    public function scopeOrdered($query)
    {
        return $query->orderBy('order_level', 'asc')
                     ->orderBy('name', 'asc');
    }

    public static function getFilteredRecords(array $filters = [], ?int $excludeId = null){
        $query = self::query()->with('role');

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        if (array_key_exists('status', $filters) && $filters['status'] !== '') {
            $query->where('status', (int) $filters['status']);
        }


        if (!empty($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }

    
        if (!empty($filters['role_id'])) {
            $query->where('role_id', $filters['role_id']);
        }

        return $query->ordered()->paginate(15)->appends($filters);
    }
}