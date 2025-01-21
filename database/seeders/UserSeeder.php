<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $passwordDefault = env('DEFAULT_PASSWORD');

        User::insert([
            [
                'id' => (string) Str::uuid(),
                'status_id' => 'active',
                'name' => 'The Super Admin',
                'email' => 'superadmin@gmail.com',
                'password' => Hash::make($passwordDefault),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => (string) Str::uuid(),
                'status_id' => 'active',
                'name' => 'The Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make($passwordDefault),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}
