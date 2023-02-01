<?php

namespace App\Modules\EmployeeType;

use App\Libraries\Crud\BaseService;

class EmployeeTypeService extends BaseService
{
    protected array $allowedRelations = [];

    public function __construct(EmployeeTypeRepository $repo)
    {
        parent::__construct($repo);
    }
}
