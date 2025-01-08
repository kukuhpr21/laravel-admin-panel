<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuHasPermission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuHasPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $dashboard = Menu::where('name', 'Dashboard')->first();
        $role = Menu::where('name', 'Role')->first();
        $menu = Menu::where('name', 'Menu')->first();
        $permission = Menu::where('name', 'Permission')->first();
        $menuWithPermission = Menu::where('name', 'Menu Permission')->first();
        $roleWithMenu = Menu::where('name', 'Role Menu')->first();
        $userWithRole = Menu::where('name', 'User Role')->first();
        $userWithMenu = Menu::where('name', 'User Menu')->first();
        $menuPermissions = [
            [
                'menu_id' => $dashboard->id,
                'permission_id' => 'view',
            ],
            [
                'menu_id' => $role->id,
                'permission_id' => 'view',
            ],
            [
                'menu_id' => $role->id,
                'permission_id' => 'create',
            ],
            [
                'menu_id' => $role->id,
                'permission_id' => 'update',
            ],
            [
                'menu_id' => $role->id,
                'permission_id' => 'delete',
            ],
            [
                'menu_id' => $menu->id,
                'permission_id' => 'view',
            ],
            [
                'menu_id' => $menu->id,
                'permission_id' => 'create',
            ],
            [
                'menu_id' => $menu->id,
                'permission_id' => 'update',
            ],
            [
                'menu_id' => $menu->id,
                'permission_id' => 'delete',
            ],
            [
                'menu_id' => $permission->id,
                'permission_id' => 'view',
            ],
            [
                'menu_id' => $permission->id,
                'permission_id' => 'create',
            ],
            [
                'menu_id' => $permission->id,
                'permission_id' => 'update',
            ],
            [
                'menu_id' => $permission->id,
                'permission_id' => 'delete',
            ],
            [
                'menu_id' => $menuWithPermission->id,
                'permission_id' => 'view',
            ],
            [
                'menu_id' => $menuWithPermission->id,
                'permission_id' => 'create',
            ],
            [
                'menu_id' => $menuWithPermission->id,
                'permission_id' => 'update',
            ],
            [
                'menu_id' => $menuWithPermission->id,
                'permission_id' => 'delete',
            ],
            [
                'menu_id' => $roleWithMenu->id,
                'permission_id' => 'view',
            ],
            [
                'menu_id' => $roleWithMenu->id,
                'permission_id' => 'create',
            ],
            [
                'menu_id' => $roleWithMenu->id,
                'permission_id' => 'update',
            ],
            [
                'menu_id' => $roleWithMenu->id,
                'permission_id' => 'delete',
            ],
            [
                'menu_id' => $userWithRole->id,
                'permission_id' => 'view',
            ],
            [
                'menu_id' => $userWithRole->id,
                'permission_id' => 'create',
            ],
            [
                'menu_id' => $userWithRole->id,
                'permission_id' => 'update',
            ],
            [
                'menu_id' => $userWithRole->id,
                'permission_id' => 'delete',
            ],
            [
                'menu_id' => $userWithMenu->id,
                'permission_id' => 'view',
            ],
            [
                'menu_id' => $userWithMenu->id,
                'permission_id' => 'create',
            ],
            [
                'menu_id' => $userWithMenu->id,
                'permission_id' => 'update',
            ],
            [
                'menu_id' => $userWithMenu->id,
                'permission_id' => 'delete',
            ],
        ];

        MenuHasPermission::insert($menuPermissions);
    }
}
