<?php

namespace App\Modules\AttendanceService;

use App\Libraries\Crud\BaseService;

class AttendanceServiceService extends BaseService
{
    protected array $allowedRelations = [];

    public function __construct(AttendanceServiceRepository $repo)
    {
        parent::__construct($repo);
    }
}
