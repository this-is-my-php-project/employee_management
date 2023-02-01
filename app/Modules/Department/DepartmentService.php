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

    public function createOne(array $params): Department
    {
        return $this->repo->createOne([
            'name' => $params['name'],
            'description' => $params['description'],
            'parent_id' => $params['parent_id'],
            'level' => $params['level'],
            'is_active' => $params['is_active'] ?? true,
            'workspace_id' => $params['workspace_id'],
        ]);
    }
}
