<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            [
                'id' => 'view',
                'name' => 'View',
            ],
            [
                'id' => 'create',
                'name' => 'Create',
            ],
            [
                'id' => 'update',
                'name' => 'Update',
            ],
            [
                'id' => 'delete',
                'name' => 'Delete',
            ],
            [
                'id' => 'change_status',
                'name' => 'Change Status',
            ],
        ];
        Permission::insert($permissions);
    }
}
