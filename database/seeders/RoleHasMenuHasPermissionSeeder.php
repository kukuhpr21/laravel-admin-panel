<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\RoleHasMenuHasPermission;
use Illuminate\Database\Seeder;

class RoleHasMenuHasPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dashboard = Menu::where('name', 'Dashboard')->first();
        $settings = Menu::where('name', 'Settings')->first();
        $mapping = Menu::where('name', 'Mapping')->first();
        $role = Menu::where('name', 'Role')->first();
        $menu = Menu::where('name', 'Menu')->first();
        $permission = Menu::where('name', 'Permission')->first();
        $roleWithMenuWithPermission = Menu::where('name', 'Role Menu Permission')->first();
        $userWithRole = Menu::where('name', 'User Role')->first();
        $status = Menu::where('name', 'Status')->first();
        $user = Menu::where('name', 'User')->first();

        $rolemenupermission = [
            [
                'role_id' => 'admin',
                'menu_id' => $dashboard->id,
                'permission_id' => 'view'
            ],
            [
                'role_id' => 'admin',
                'menu_id' => $user->id,
                'permission_id' => 'view'
            ],
            [
                'role_id' => 'admin',
                'menu_id' => $user->id,
                'permission_id' => 'create'
            ],
            [
                'role_id' => 'admin',
                'menu_id' => $user->id,
                'permission_id' => 'update'
            ],
            [
                'role_id' => 'admin',
                'menu_id' => $user->id,
                'permission_id' => 'change_status'
            ],
            [
                'role_id' => 'super_admin',
                'menu_id' => $dashboard->id,
                'permission_id' => 'view'
            ],
            [
                'role_id' => 'super_admin',
                'menu_id' => $user->id,
                'permission_id' => 'view'
            ],
            [
                'role_id' => 'super_admin',
                'menu_id' => $user->id,
                'permission_id' => 'create'
            ],
            [
                'role_id' => 'super_admin',
                'menu_id' => $user->id,
                'permission_id' => 'update'
            ],
            [
                'role_id' => 'super_admin',
                'menu_id' => $user->id,
                'permission_id' => 'change_status'
            ],
            [
                'role_id' => 'super_admin',
                'menu_id' => $status->id,
                'permission_id' => 'view',
            ],
            [
                'role_id' => 'super_admin',
                'menu_id' => $status->id,
                'permission_id' => 'create',
            ],
            [
                'role_id' => 'super_admin',
                'menu_id' => $status->id,
                'permission_id' => 'update',
            ],
            [
                'role_id' => 'super_admin',
                'menu_id' => $status->id,
                'permission_id' => 'delete',
            ],
            [
                'role_id' => 'super_admin',
                'menu_id' => $role->id,
                'permission_id' => 'view',
            ],
            [
                'role_id' => 'super_admin',
                'menu_id' => $role->id,
                'permission_id' => 'create',
            ],
            [
                'role_id' => 'super_admin',
                'menu_id' => $role->id,
                'permission_id' => 'update',
            ],
            [
                'role_id' => 'super_admin',
                'menu_id' => $role->id,
                'permission_id' => 'delete',
            ],
            [
                'role_id' => 'super_admin',
                'menu_id' => $menu->id,
                'permission_id' => 'view',
            ],
            [
                'role_id' => 'super_admin',
                'menu_id' => $menu->id,
                'permission_id' => 'create',
            ],
            [
                'role_id' => 'super_admin',
                'menu_id' => $menu->id,
                'permission_id' => 'update',
            ],
            [
                'role_id' => 'super_admin',
                'menu_id' => $menu->id,
                'permission_id' => 'delete',
            ],
            [
                'role_id' => 'super_admin',
                'menu_id' => $permission->id,
                'permission_id' => 'view',
            ],
            [
                'role_id' => 'super_admin',
                'menu_id' => $permission->id,
                'permission_id' => 'create',
            ],
            [
                'role_id' => 'super_admin',
                'menu_id' => $permission->id,
                'permission_id' => 'update',
            ],
            [
                'role_id' => 'super_admin',
                'menu_id' => $permission->id,
                'permission_id' => 'delete',
            ],
            [
                'role_id' => 'super_admin',
                'menu_id' => $roleWithMenuWithPermission->id,
                'permission_id' => 'view',
            ],
            [
                'role_id' => 'super_admin',
                'menu_id' => $roleWithMenuWithPermission->id,
                'permission_id' => 'create',
            ],
            [
                'role_id' => 'super_admin',
                'menu_id' => $roleWithMenuWithPermission->id,
                'permission_id' => 'update',
            ],
            [
                'role_id' => 'super_admin',
                'menu_id' => $roleWithMenuWithPermission->id,
                'permission_id' => 'delete',
            ],
            [
                'role_id' => 'super_admin',
                'menu_id' => $userWithRole->id,
                'permission_id' => 'view',
            ],
            [
                'role_id' => 'super_admin',
                'menu_id' => $userWithRole->id,
                'permission_id' => 'create',
            ],
            [
                'role_id' => 'super_admin',
                'menu_id' => $userWithRole->id,
                'permission_id' => 'update',
            ],
            [
                'role_id' => 'super_admin',
                'menu_id' => $userWithRole->id,
                'permission_id' => 'delete',
            ],
            [
                'role_id' => 'super_admin',
                'menu_id' => $settings->id,
                'permission_id' => 'view',
            ],
            [
                'role_id' => 'super_admin',
                'menu_id' => $mapping->id,
                'permission_id' => 'view',
            ],
        ];
        RoleHasMenuHasPermission::insert($rolemenupermission);
    }
}
