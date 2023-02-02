<?php

namespace App\Modules\JobDetail;

use App\Libraries\Crud\BaseService;
use App\Modules\Role\Constants\RoleConstants;

class JobDetailService extends BaseService
{
    protected array $allowedRelations = [];

    public function __construct(JobDetailRepository $repo)
    {
        parent::__construct($repo);
    }

    public function createOne(array $payload): JobDetail
    {
        return $this->repo->createOne([
            'title' => $payload['title'],
            'description' => $payload['description'],
            'employee_type_id' => $payload['employee_type_id'],
            'role_id' => $payload['role_id'],
            'department_id' => $payload['department_id'],
            'workspace_id' => $payload['workspace_id'],
            'user_id' => $payload['user_id'],
        ]);
    }

    public function createDefault(int $workspaceId, int $employeeTypeId, int $roleId, int $departmentId, $userId)
    {
        return $this->repo->createOne([
            'title' => 'Default',
            'description' => 'Default job detail for workspace',
            'employee_type_id' => $employeeTypeId,
            'role_id' => $roleId,
            'department_id' => $departmentId,
            'workspace_id' => $workspaceId,
            'user_id' => $userId,
        ]);
    }
}
