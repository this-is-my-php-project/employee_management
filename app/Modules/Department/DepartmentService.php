<?php

namespace App\Modules\Department;

use App\Libraries\Crud\BaseService;

class DepartmentService extends BaseService
{
    protected array $allowedRelations = [
        'workspace',
        'jobDetails',
    ];

    public function __construct(DepartmentRepository $repo)
    {
        parent::__construct($repo);
    }

    public function createOne(array $params): Department
    {
        return $this->repo->createOne([
            'name' => $params['name'],
            'description' => $params['description'],
            'parent_id' => 0,
            'level' => $params['level'],
            'is_active' => $params['is_active'] ?? true,
            'workspace_id' => $params['workspace_id'],
        ]);
    }

    public function createDefault(int $workspaceId, string $workspaceName)
    {
        return $this->repo->createOne([
            'name' => 'Default',
            'description' => 'Default department for ' . $workspaceName,
            'parent_id' => 0,
            'level' => 0,
            'is_active' => true,
            'is_default' => true,
            'workspace_id' => $workspaceId,
        ]);
    }

    public function deleteOne(string|int $id): ?Department
    {
        $department = $this->repo->getOneOrFail($id, []);

        if ($department->is_default === true) {
            throw new \Exception('Cannot delete default department');
        }

        if ($department->jobDetails()->count() > 0) {
            throw new \Exception('Cannot delete department with user');
        }

        $department->delete();
        return $department;
    }
}
