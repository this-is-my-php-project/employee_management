<?php

namespace Database\Seeders;

use App\Modules\EmployeeType\EmployeeType;
use App\Modules\EmployeeType\Constants\EmployeeTypeConstants;
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
                'name' => EmployeeTypeConstants::FULL_TIME['name'],
                'description' => 'Full Time Employee',
                'is_active' => true,
                'is_global' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => EmployeeTypeConstants::PART_TIME['name'],
                'description' => 'Part Time Employee',
                'is_active' => true,
                'is_global' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => EmployeeTypeConstants::CONTRACT['name'],
                'description' => 'Contract Employee',
                'is_active' => true,
                'is_global' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'name' => EmployeeTypeConstants::INTERN['name'],
                'description' => 'Intern Employee',
                'is_active' => true,
                'is_global' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'name' => EmployeeTypeConstants::TEMPORARY['name'],
                'description' => 'Temporary Employee',
                'is_active' => true,
                'is_global' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 6,
                'name' => EmployeeTypeConstants::CASUAL['name'],
                'description' => 'Casual Employee',
                'is_active' => true,
                'is_global' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 7,
                'name' => EmployeeTypeConstants::SEASONAL['name'],
                'description' => 'Seasonal Employee',
                'is_active' => true,
                'is_global' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 8,
                'name' => EmployeeTypeConstants::VOLUNTEER['name'],
                'description' => 'Volunteer Employee',
                'is_active' => true,
                'is_global' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 9,
                'name' => EmployeeTypeConstants::APPRENTICE['name'],
                'description' => 'Apprentice Employee',
                'is_active' => true,
                'is_global' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 10,
                'name' => EmployeeTypeConstants::TRAINEE['name'],
                'description' => 'Trainee Employee',
                'is_active' => true,
                'is_global' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 11,
                'name' => EmployeeTypeConstants::PROBATION['name'],
                'description' => 'Probation Employee',
                'is_active' => true,
                'is_global' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 12,
                'name' => EmployeeTypeConstants::PERMANENT['name'],
                'description' => 'Permanent Employee',
                'is_active' => true,
                'is_global' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 13,
                'name' => EmployeeTypeConstants::NORMAL['name'],
                'description' => 'NORMAL Employee',
                'is_active' => true,
                'is_global' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        EmployeeType::insert($employees);
    }
}
