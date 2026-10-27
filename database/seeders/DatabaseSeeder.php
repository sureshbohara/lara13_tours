<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolesTableSeeder::class,
            AdminsTableSeeder::class,
            RolePermissionSeeder::class,
            SettingTableSeeder::class,
            BannerSeeder::class,
            ReviewSeeder::class,
            ServiceSeeder::class,
            FaqSeeder::class,
            PageSeeder::class,
            TeamSeeder::class,
            CategorySeeder::class,
        ]);
    }
}