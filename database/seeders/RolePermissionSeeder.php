<?php

namespace Database\Seeders;

use App\Modules\Role\Role;
use App\Modules\User\User;
use Illuminate\Database\Seeder;
use App\Modules\Permission\Permission;
use App\Modules\Permission\PermissionService;
use App\Modules\Role\Constants\RoleConstants;
use App\Modules\Permission\Constants\PermissionConstants;
use App\Modules\User\Constants\UserConstants;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::truncate();
        Permission::truncate();

        /**
         * Roles
         */
        $role = [
            [
                'id' => 1,
                'name' => RoleConstants::SUPER_ADMIN,
                'description' => 'Owner of the system. Has all permissions. Cannot be deleted. Cannot be edited. Cannot be disabled. Cannot be assigned to a user. Cannot be assigned to a permission. Cannot be assigned to another role.',
                'status' => true,
                'level' => 0,
                'parent_id' => 0,
                'created_by_workspace' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        Role::insert($role);

        // /**
        //  * Permissions
        //  */
        // foreach (PermissionConstants::getAdminPermissions() as $key => $value) {
        //     $permission[] = [
        //         'id' => $key + 1,
        //         'name' => $value,
        //         'title' => PermissionService::getTitle($value),
        //         'description' => PermissionService::getLowerCase($value),
        //         'status' => true,
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ];
        // }
        // Permission::insert($permission);

        // /**
        //  * Assign all permissions to admin roles
        //  */
        // $role = Role::where('name', RoleConstants::ADMIN)->first();
        // $role->permissions()->sync(Permission::all()->pluck('id')->toArray());

        /**
         * Assign super admin role to super admin user
         */
        $user = User::where('name', UserConstants::SUPER_ADMIN)->first();
        $user->roles()->sync(Role::where('name', RoleConstants::SUPER_ADMIN)->first()->id);
    }
}
