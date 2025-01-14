<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'id' => 'super_admin',
                'name' => 'Super Admin',
                'list_role_available' => 'admin',
            ],
            [
                'id' => 'admin',
                'name' => 'Admin',
                'list_role_available' => 'admin',
            ],
        ];

        Role::insert($roles);
    }
}
