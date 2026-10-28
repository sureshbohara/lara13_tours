<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
  
    private const ENTITIES = [
    
        'user',
        'role',
        'permission',
        'login_activity',

     
        'category',
        'package',
        'fixed_departure',

        
        'page',
        'blog',
        'media',
        'menu',

 
        'subscriber',
        'coupon',

    
        'banner',
        'faq',
        'review',
        'gallery',
        'team',


        'setting',
        'site_health',
        'backup',
        'notification',
    ];

    public function run(): void
    {

        $this->seedRole('super_admin', self::ENTITIES, []);
        
      
        $adminFull = array_diff(self::ENTITIES, ['role', 'permission', 'backup']);
        $this->seedRole('admin', $adminFull, [
            'role' => ['read'],
            'permission' => ['read'],
            'backup' => ['read', 'create'] 
        ]);
        

        $this->seedRole('sub_admin', [
            'category', 'package', 'fixed_departure',
            'page', 'blog', 'media', 'menu',
            'banner', 'faq', 'review', 'gallery', 'team',
            'subscriber', 'coupon', 'notification'
        ], [
            'user' => ['read'],
            'role' => ['read'],
            'permission' => ['read'],
            'setting' => ['read'],
            'site_health' => ['read'],
            'backup' => ['read'],
            'login_activity' => ['read']
        ]);
        
     
        $this->seedRole('normal_user', [], [
            'user' => ['read'],
            'role' => ['read'],
            'permission' => ['read'],
            'package' => ['read'],
            'category' => ['read'],
            'blog' => ['read', 'create', 'update'], 
            'page' => ['read'],
            'review' => ['read'],
            'faq' => ['read'],
            'setting' => ['read'],
        ]);

        $this->command->info('✓ All role permissions seeded successfully!');
    }

    private function seedRole(string $roleName, array $fullAccess, array $partialAccess): void
    {
        $role = Role::where('name', $roleName)->first();
        
        if (!$role) {
            $this->command->warn("⚠️ Role '{$roleName}' not found. Please run RolesTableSeeder first.");
            return;
        }

        $permission = Permission::firstOrNew(['role_id' => $role->id]);
        $perms = $permission->permissions ?? [];


        foreach (self::ENTITIES as $entity) {
            $perms[$entity] = [
                'read'   => '0',
                'create' => '0',
                'update' => '0',
                'delete' => '0'
            ];
        }


        foreach ($fullAccess as $entity) {
            if (in_array($entity, self::ENTITIES)) {
                $perms[$entity] = [
                    'read'   => '1',
                    'create' => '1',
                    'update' => '1',
                    'delete' => '1'
                ];
            }
        }

      
        foreach ($partialAccess as $entity => $actions) {
            if (in_array($entity, self::ENTITIES)) {
                $perms[$entity] = [
                    'read'   => in_array('read', $actions) ? '1' : '0',
                    'create' => in_array('create', $actions) ? '1' : '0',
                    'update' => in_array('update', $actions) ? '1' : '0',
                    'delete' => in_array('delete', $actions) ? '1' : '0'
                ];
            }
        }

        $permission->permissions = $perms;
        $permission->save();
        
        $this->command->info("✓ {$role->display_name} permissions set successfully.");
    }
}