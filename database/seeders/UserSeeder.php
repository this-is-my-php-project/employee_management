<?php

namespace Database\Seeders;

use App\Modules\User\Constants\UserConstants;
use App\Modules\User\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => UserConstants::SUPER_ADMIN,
            'email' => 'superadmin@gmail.com',
            'password' => bcrypt('12345'),
            'is_active' => true,
            'is_super_admin' => true,
        ]);

        // User::create([
        //     'name' => UserConstants::ADMIN,
        //     'email' => 'admin1@gmail.com',
        //     'password' => bcrypt('12345'),
        //     'is_active' => true,
        // ]);

        // User::create([
        //     'name' => 'admin 2',
        //     'email' => 'admin2@gmail.com',
        //     'password' => bcrypt('12345'),
        //     'is_active' => true,
        // ]);

        // User::create([
        //     'name' => 'admin 3',
        //     'email' => 'admin3@gmail.com',
        //     'password' => bcrypt('12345'),
        //     'is_active' => true,
        // ]);

        // User::create([
        //     'name' => 'admin 4',
        //     'email' => 'admin4@gmail.com',
        //     'password' => bcrypt('12345'),
        //     'is_active' => true,
        // ]);
    }
}
