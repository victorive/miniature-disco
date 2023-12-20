<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'view_posts', 'read_posts', 'update_posts', 'delete_posts', 'create_posts'
        ];

        collect($permissions)->map(function ($permission) {
            Permission::query()->updateOrCreate(['name' => $permission]);
        });

        $admin = Role::create(['name' => 'Admin']);
        $user = Role::create(['name' => 'User']);

        $admin->givePermissionTo('view_posts', 'read_posts', 'update_posts', 'delete_posts');
        $user->givePermissionTo('create_posts');
    }
}
