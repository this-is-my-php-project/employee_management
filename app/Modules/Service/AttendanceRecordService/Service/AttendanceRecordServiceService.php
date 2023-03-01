<?php

namespace App\Modules\Service/AttendanceRecordService;

use App\Libraries\Crud\BaseService;

class Service/AttendanceRecordServiceService extends BaseService
{
    protected array $allowedRelations = [];

    public function __construct(Service/AttendanceRecordServiceRepository $repo)
    {
        parent::__construct($repo);
    }
}
