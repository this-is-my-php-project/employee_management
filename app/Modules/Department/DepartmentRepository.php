<?php

namespace App\Modules\Department;

use App\Libraries\Crud\BaseRepository;
use App\Modules\Department\Department;

class DepartmentRepository extends BaseRepository
{
    public function __construct(Department $department)
    {
        parent::__construct($department);
    }
}
