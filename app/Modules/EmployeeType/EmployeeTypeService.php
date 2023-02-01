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

    public function createOne(array $params): EmployeeType
    {
        return $this->repo->createOne([
            'name' => $params['name'],
            'description' => $params['description'] ?? null,
            'is_active' => $params['is_active'] ?? true,
            'workspace_id' => $params['workspace_id'],
        ]);
    }
}
