<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            'view_users',
            'edit_users',
            'delete_users',
            'view_admins',
            'create_admins',
            'create_ads',
            'delete_ads',
            'edit_admins',
            'delete_admins',
            'view_roles',
            'create_roles',
            'edit_roles',
            'delete_roles'
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission,
                'guard_name' => 'admin'
            ]);
        }
    }
} 