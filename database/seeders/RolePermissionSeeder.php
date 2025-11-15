<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // Truncate permissions table and reset auto-increment
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Permission::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        DB::statement('ALTER TABLE permissions AUTO_INCREMENT = 1');
        // Clear spatie permission cache
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        // Create permissions
        $permissions = [
            'view_users',
            'edit_users',
            'view_roles',
            'create_roles',
            'edit_roles',
            'delete_roles',
            'view_admins',
            'create_admins',
            'edit_admins',
            'delete_admins',
            'view_ads',
            'create_ads',
            'delete_ads',
            'edit_ads',
            'view_categories',
            'add_categories',
            'edit_categories',
            'delete_categoris',
            'list reports',
            'user reports',
            'ads reports',
            'finicial reports',
            'list plans',
            'add plans',
            'edit plans',
            'delete plans',
            'list notifications',
            'send notifications',
            'list attributes',
            'add attributes',
            'list currencies',
            'edit currencies',
            'list cities',
            'edit cities',
            'list areas',
            'edit areas'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'admin']);
        }

        $superAdmin = Role::where('name','Super Admin')->first();

        if(!$superAdmin){
            // Create roles and assign permissions
            $superAdmin = Role::create(['name' => 'Super Admin', 'guard_name' => 'admin']);
        }

        $superAdmin->givePermissionTo(Permission::all());
    }
}
