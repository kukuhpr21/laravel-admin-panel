<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            [
                'id' => 'registered',
                'name' => 'Registered'
            ],
            [
                'id' => 'changed_password',
                'name' => 'Changed Password'
            ],
            [
                'id' => 'active',
                'name' => 'Active'
            ],
            [
                'id' => 'inactive',
                'name' => 'Inactive'
            ],
            [
                'id' => 'deleted',
                'name' => 'Deleted'
            ],
        ];

        Status::create( $statuses );
    }
}
