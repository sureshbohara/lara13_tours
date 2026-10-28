<?php

declare(strict_types=1);

namespace App\Services\Admin;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class PermissionService
{
  
    protected array $entities = [
        // Administration
        'user',
        'role',
        'permission',
        'login_activity',

        // Trip & Travel
        'category',
        'package',
        'fixed_departure',

        // Content Management
        'page',
        'blog',
        'media',
        'menu',

        // Marketing
        'subscriber',
        'coupon',

        // Site Elements
        'banner',
        'faq',
        'review',
        'gallery',
        'team',

        // System
        'setting',
        'site_health',
        'backup',
        'notification',
    ];

    protected array $actions = [
        'read',
        'create',
        'update',
        'delete',
    ];

    public function __construct(protected Permission $permission)
    {
        //
    }

    public function getPermissionData(?int $roleId = null): array
    {
        $perm = $roleId
            ? $this->permission->where('role_id', $roleId)->first()
            : null;

        return [
            'entities' => $this->entities,
            'actions' => $this->actions,
            'permissions' => $perm?->permissions ?? $this->getDefaultPermissions(),
            'roles' => Role::active()->orderBy('name')->get(),
        ];
    }

    public function validatePermissions(array $input): array
    {
        $validated = [];

        foreach ($this->entities as $entity) {
            foreach ($this->actions as $action) {
                $validated[$entity][$action] = ($input[$entity][$action] ?? '') === '1' ? '1' : '0';
            }
        }

        return $validated;
    }

    public function createPermissions(int $roleId, array $input): Permission
    {
        return $this->permission->updateOrCreate(
            ['role_id' => $roleId],
            ['permissions' => $this->validatePermissions($input)]
        );
    }

    public function updatePermissions(int $permissionId, array $input): Permission
    {
        $perm = $this->permission->findOrFail($permissionId);
        $perm->update(['permissions' => $this->validatePermissions($input)]);
        
        if (method_exists($perm, 'clearAdminCache')) {
            $perm->clearAdminCache();
        }

        return $perm->fresh();
    }

    public function deletePermissions(int $id): bool
    {
        $perm = $this->permission->findOrFail($id);

        if ($perm->role?->name === 'super_admin') {
            throw new \Exception('Super Admin permissions are locked.');
        }

        if (method_exists($perm, 'clearAdminCache')) {
            $perm->clearAdminCache();
        }

        return $perm->delete();
    }

    protected function getDefaultPermissions(): array
    {
        $default = [];

        foreach ($this->entities as $entity) {
            $default[$entity] = array_fill_keys($this->actions, '0');
        }

        // Default safe permissions for new roles
        $default['user']['read'] = '1';
        $default['setting']['read'] = '1';
        $default['site_health']['read'] = '1';

        return $default;
    }
}