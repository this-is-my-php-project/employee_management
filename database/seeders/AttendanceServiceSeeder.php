<?php

namespace Database\Seeders;

use App\Modules\AttendanceService\AttendanceService;
use App\Modules\AttendanceService\Constants\AttendanceServiceConstants;
use Illuminate\Database\Seeder;

class AttendanceServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AttendanceService::create([
            'id' => AttendanceServiceConstants::ATTENDANCE_SERVICE['id'],
            'name' => AttendanceServiceConstants::ATTENDANCE_SERVICE['name'],
            'description' => AttendanceServiceConstants::ATTENDANCE_SERVICE['description'],
            'icon' => AttendanceServiceConstants::ATTENDANCE_SERVICE['icon'],
            'created_at' => AttendanceServiceConstants::ATTENDANCE_SERVICE['created_at'],
            'updated_at' => AttendanceServiceConstants::ATTENDANCE_SERVICE['updated_at'],
        ]);
    }
}
