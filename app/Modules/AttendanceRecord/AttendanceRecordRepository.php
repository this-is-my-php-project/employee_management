<?php

namespace App\Modules\AttendanceRecord;

use App\Libraries\Crud\BaseRepository;
use App\Modules\AttendanceRecord\AttendanceRecord;

class AttendanceRecordRepository extends BaseRepository
{
    public function __construct(AttendanceRecord $attendanceRecord)
    {
        parent::__construct($attendanceRecord);
    }
}
