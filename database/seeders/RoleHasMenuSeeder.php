<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\RoleHasMenu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleHasMenuSeeder extends Seeder
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
        $menuWithPermission = Menu::where('name', 'Menu Permission')->first();
        $roleWithMenu = Menu::where('name', 'Role Menu')->first();
        $userWithRole = Menu::where('name', 'User Role')->first();
        $userWithMenu = Menu::where('name', 'User Menu')->first();

        $rolemenu = [
            [
                'role_id' => 'admin',
                'menu_id' => $dashboard->id
            ],
            [
                'role_id' => 'super_admin',
                'menu_id' => $dashboard->id
            ],
            [
                'role_id' => 'super_admin',
                'menu_id' => $role->id
            ],
            [
                'role_id' => 'super_admin',
                'menu_id' => $menu->id
            ],
            [
                'role_id' => 'super_admin',
                'menu_id' => $permission->id
            ],
            [
                'role_id' => 'super_admin',
                'menu_id' => $menuWithPermission->id
            ],
            [
                'role_id' => 'super_admin',
                'menu_id' => $roleWithMenu->id
            ],
            [
                'role_id' => 'super_admin',
                'menu_id' => $userWithRole->id
            ],
            [
                'role_id' => 'super_admin',
                'menu_id' => $userWithMenu->id
            ],
            [
                'role_id' => 'super_admin',
                'menu_id' => $settings->id
            ],
            [
                'role_id' => 'super_admin',
                'menu_id' => $mapping->id
            ],
        ];
        RoleHasMenu::insert($rolemenu);
    }
}
