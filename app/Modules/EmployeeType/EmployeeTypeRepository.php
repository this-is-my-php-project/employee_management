<?php

namespace App\Modules\EmployeeType;

use App\Libraries\Crud\BaseRepository;
use App\Modules\EmployeeType\EmployeeType;

class EmployeeTypeRepository extends BaseRepository
{
    public function __construct(EmployeeType $employeeType)
    {
        parent::__construct($employeeType);
    }
}
