<?php

namespace Database\Seeders;

use App\Modules\EmployeeType\EmployeeType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employees = [
            [
                'id' => 1,
                'name' => 'Full Time',
                'description' => 'Full Time Employee',
                'is_active' => true,
                'is_global' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Part Time',
                'description' => 'Part Time Employee',
                'is_active' => true,
                'is_global' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'Contract',
                'description' => 'Contract Employee',
                'is_active' => true,
                'is_global' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'name' => 'Intern',
                'description' => 'Intern Employee',
                'is_active' => true,
                'is_global' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'name' => 'Temporary',
                'description' => 'Temporary Employee',
                'is_active' => true,
                'is_global' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 6,
                'name' => 'Casual',
                'description' => 'Casual Employee',
                'is_active' => true,
                'is_global' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 7,
                'name' => 'Seasonal',
                'description' => 'Seasonal Employee',
                'is_active' => true,
                'is_global' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 8,
                'name' => 'Volunteer',
                'description' => 'Volunteer Employee',
                'is_active' => true,
                'is_global' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 9,
                'name' => 'Apprentice',
                'description' => 'Apprentice Employee',
                'is_active' => true,
                'is_global' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 10,
                'name' => 'Trainee',
                'description' => 'Trainee Employee',
                'is_active' => true,
                'is_global' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 11,
                'name' => 'Probation',
                'description' => 'Probation Employee',
                'is_active' => true,
                'is_global' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 12,
                'name' => 'Permanent',
                'description' => 'Permanent Employee',
                'is_active' => true,
                'is_global' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        EmployeeType::insert($employees);
    }
}
