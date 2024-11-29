<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\User;
use App\Models\UserHasMenu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserHasMenuSeeder extends Seeder
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
        $userSuperAdmin = User::where('email', 'superadmin@gmail.com')->first();
        $userAdmin = User::where('email', 'admin@gmail.com')->first();

        $usermenu = [
            [
                'user_id' => $userAdmin->id,
                'menu_id' => $dashboard->id
            ],
            [
                'user_id' => $userSuperAdmin->id,
                'menu_id' => $dashboard->id
            ],
            [
                'user_id' => $userSuperAdmin->id,
                'menu_id' => $role->id
            ],
            [
                'user_id' => $userSuperAdmin->id,
                'menu_id' => $menu->id
            ],
            [
                'user_id' => $userSuperAdmin->id,
                'menu_id' => $permission->id
            ],
            [
                'user_id' => $userSuperAdmin->id,
                'menu_id' => $menuWithPermission->id
            ],
            [
                'user_id' => $userSuperAdmin->id,
                'menu_id' => $roleWithMenu->id
            ],
            [
                'user_id' => $userSuperAdmin->id,
                'menu_id' => $userWithRole->id
            ],
            [
                'user_id' => $userSuperAdmin->id,
                'menu_id' => $userWithMenu->id
            ],
            [
                'user_id' => $userSuperAdmin->id,
                'menu_id' => $settings->id
            ],
            [
                'user_id' => $userSuperAdmin->id,
                'menu_id' => $mapping->id
            ],
        ];
        UserHasMenu::insert($usermenu);
    }
}
