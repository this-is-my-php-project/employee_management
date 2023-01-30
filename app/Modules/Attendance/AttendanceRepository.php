<?php

namespace App\Modules\Attendance;

use App\Libraries\Crud\BaseRepository;
use App\Modules\Attendance\Attendance;

class AttendanceRepository extends BaseRepository
{
    public function __construct(Attendance $attendance)
    {
        parent::__construct($attendance);
    }
}
