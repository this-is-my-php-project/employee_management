<?php

namespace App\Modules\Service/AttendanceRecordService;

use App\Libraries\Crud\BaseRepository;
use App\Modules\Service/AttendanceRecordService\Service/AttendanceRecordService;

class Service/AttendanceRecordServiceRepository extends BaseRepository
{
    public function __construct(Service/AttendanceRecordService $service/AttendanceRecordService)
    {
        parent::__construct($service/AttendanceRecordService);
    }
}
