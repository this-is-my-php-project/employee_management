<?php

namespace Database\Seeders;

use App\Modules\Role\Constants\RoleConstants;
use App\Modules\Role\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'id' => 1,
                'name' => RoleConstants::ADMIN['name'],
                'key' => RoleConstants::ADMIN['key'],
                'description' => 'Administrator of a workspace',
                'parent_id' => 1,
                'level' => 1,
                'is_active' => true,
                'is_global' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => RoleConstants::MANAGER['name'],
                'key' => RoleConstants::MANAGER['key'],
                'description' => 'Manager of a workspace',
                'parent_id' => 2,
                'level' => 2,
                'is_active' => true,
                'is_global' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => RoleConstants::MEMBER['name'],
                'key' => RoleConstants::MEMBER['key'],
                'description' => 'Member of a workspace',
                'parent_id' => 3,
                'level' => 3,
                'is_active' => true,
                'is_global' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        Role::insert($roles);
    }
}
