<?php

namespace Database\Seeders;

use App\Modules\User\Constants\UserConstants;
use App\Modules\User\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        User::create([
            'name' => UserConstants::SUPER_ADMIN,
            'email' => 'superadmin@gmail.com',
            'password' => bcrypt('12345'),
            'status' => true,
        ]);

        User::create([
            'name' => UserConstants::ADMIN,
            'email' => 'admin1@gmail.com',
            'password' => bcrypt('12345'),
            'status' => true,
        ]);
    }
}
