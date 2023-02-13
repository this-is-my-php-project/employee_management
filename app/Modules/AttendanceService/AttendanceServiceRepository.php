<?php

namespace App\Modules\AttendanceService;

use App\Libraries\Crud\BaseRepository;
use App\Modules\AttendanceService\AttendanceService;

class AttendanceServiceRepository extends BaseRepository
{
    public function __construct(AttendanceService $attendanceService)
    {
        parent::__construct($attendanceService);
    }
}
