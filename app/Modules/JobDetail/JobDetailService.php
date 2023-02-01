<?php

namespace App\Modules\JobDetail;

use App\Libraries\Crud\BaseService;

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
        ]);
    }
}
