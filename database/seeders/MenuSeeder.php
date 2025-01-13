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

        $menuSettings = Menu::create([
            'name' => 'Settings',
            'icon' => 'ri-tools-line',
            'parent' => 0,
            'order' => 100,
        ]);

        $subMenuSettings = [
            [
                'name' => 'Role',
                'link' => 'settings/roles',
                'link_alias' => 'roles',
                'parent' => $menuSettings->id,
                'order' => 1,
            ],
            [
                'name' => 'Menu',
                'link' => 'settings/menus',
                'link_alias' => 'menus',
                'parent' => $menuSettings->id,
                'order' => 2,
            ],
            [
                'name' => 'Permission',
                'link' => 'settings/permissions',
                'link_alias' => 'permissions',
                'parent' => $menuSettings->id,
                'order' => 3,
            ],
        ];

        Menu::insert($subMenuSettings);

        $menumapping = Menu::create([
            'name' => 'Mapping',
            'parent' => $menuSettings->id,
            'order' => 4,
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
                'name' => 'Menu Permission',
                'link' => 'settings/mapping/menus-permissions',
                'link_alias' => 'menus-permissions',
                'parent' => $menumapping->id,
                'order' => 2,
            ],
            [
                'name' => 'Role Menu',
                'link' => 'settings/mapping/roles-menus',
                'link_alias' => 'roles-menus',
                'parent' => $menumapping->id,
                'order' => 3,
            ],
            [
                'name' => 'User Role',
                'link' => 'settings/mapping/users-roles',
                'link_alias' => 'users-roles',
                'parent' => $menumapping->id,
                'order' => 4,
            ],
            [
                'name' => 'User Menu',
                'link' => 'settings/mapping/users-menus',
                'link_alias' => 'users-menus',
                'parent' => $menumapping->id,
                'order' => 5,
            ]
        ];

        Menu::insert($subMenuMapping);
    }
}
