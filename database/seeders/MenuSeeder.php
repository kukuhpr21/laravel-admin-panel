<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Menu::create([
            'name' => 'Dashboard',
            'icon' => 'ri-home-6-line',
            'link' => 'dashboard',
            'link_alias' => 'dashboard',
            'parent' => 0,
            'order' => 1,
        ]);

        Menu::create([
            'name' => 'User',
            'icon' => 'ri-user-line',
            'link' => 'users',
            'link_alias' => 'users',
            'parent' => 0,
            'order' => 2,
        ]);

        Menu::create([
            'name' => 'Profile',
            'link' => 'profile',
            'link_alias' => 'profile',
            'parent' => 0,
            'order' => 0,
        ]);

        $menuSettings = Menu::create([
            'name' => 'Settings',
            'icon' => 'ri-tools-line',
            'parent' => 0,
            'order' => 100,
        ]);

        $subMenuSettings = [
            [
                'name' => 'Status',
                'link' => 'settings/statuses',
                'link_alias' => 'statuses',
                'parent' => $menuSettings->id,
                'order' => 1,
            ],
            [
                'name' => 'Role',
                'link' => 'settings/roles',
                'link_alias' => 'roles',
                'parent' => $menuSettings->id,
                'order' => 2,
            ],
            [
                'name' => 'Menu',
                'link' => 'settings/menus',
                'link_alias' => 'menus',
                'parent' => $menuSettings->id,
                'order' => 3,
            ],
            [
                'name' => 'Permission',
                'link' => 'settings/permissions',
                'link_alias' => 'permissions',
                'parent' => $menuSettings->id,
                'order' => 4,
            ],
        ];

        Menu::insert($subMenuSettings);

        $menumapping = Menu::create([
            'name' => 'Mapping',
            'parent' => $menuSettings->id,
            'order' => 5,
        ]);

        $subMenuMapping = [
            [
                'name' => 'Role Menu Permission',
                'link' => 'settings/mapping/roles-menus-permissions',
                'link_alias' => 'roles-menus-permissions',
                'parent' => $menumapping->id,
                'order' => 1,
            ],
            [
                'name' => 'User Role',
                'link' => 'settings/mapping/users-roles',
                'link_alias' => 'users-roles',
                'parent' => $menumapping->id,
                'order' => 2,
            ],
        ];

        Menu::insert($subMenuMapping);
    }
}
