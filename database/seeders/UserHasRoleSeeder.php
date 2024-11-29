<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserHasRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserHasRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userSuperAdmin = User::where('email', 'superadmin@gmail.com')->first();
        $userAdmin = User::where('email', 'admin@gmail.com')->first();
        UserHasRole::insert([
            [
                'user_id' => $userSuperAdmin->id,
                'role_id' => 'super_admin',
            ],
            [
                'user_id' => $userAdmin->id,
                'role_id' => 'admin',
            ],
        ]);
    }
}
