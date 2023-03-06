<?php

namespace App\Modules\EmployeeType;

use App\Libraries\Crud\BaseRepository;
use App\Modules\EmployeeType\Constants\EmployeeTypeConstants;
use App\Modules\EmployeeType\EmployeeType;

class EmployeeTypeRepository extends BaseRepository
{
    public function __construct(EmployeeType $employeeType)
    {
        parent::__construct($employeeType);
    }

    public function getDefaultEmployeeId(): int
    {
        return $this->model->where('name', '=', EmployeeTypeConstants::NORMAL['name'])->first()->id;
    }
}
