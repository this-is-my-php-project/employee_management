<?php

namespace App\Modules\EmployeeType;

use App\Libraries\Crud\BaseService;
use App\Modules\Workspace\Workspace;

class EmployeeTypeService extends BaseService
{
    protected array $allowedRelations = [
        'workspaces',
    ];
    protected array $filterable = [];
    protected $employeeRepo;

    public function __construct(EmployeeTypeRepository $repo)
    {
        parent::__construct($repo);
        $this->employeeRepo = $repo;
    }

    /**
     * @param array $params
     * @return EmployeeType
     */
    public function createOne(array $params): EmployeeType
    {
        return $this->repo->createOne([
            'name' => $params['name'],
            'description' => $params['description'] ?? null,
            'is_active' => $params['is_active'] ?? true,
            'workspace_id' => $params['workspace_id'],
        ]);
    }

    /**
     * @return int
     */
    public function getDefaultEmployeeId(): int
    {
        return $this->employeeRepo->getDefaultEmployeeId();
    }

    public function getInviteEmployeeId(): int
    {
        return $this->employeeRepo->getDefaultEmployeeId();
    }
}
