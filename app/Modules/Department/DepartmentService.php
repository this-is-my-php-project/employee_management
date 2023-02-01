<?php

namespace App\Modules\Department;

use App\Libraries\Crud\BaseService;

class DepartmentService extends BaseService
{
    protected array $allowedRelations = [];

    public function __construct(DepartmentRepository $repo)
    {
        parent::__construct($repo);
    }
}
