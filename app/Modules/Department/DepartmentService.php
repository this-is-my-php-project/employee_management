<?php

namespace App\Modules\Department;

use App\Libraries\Crud\BaseService;
use Illuminate\Support\Facades\DB;

class DepartmentService extends BaseService
{
    protected array $allowedRelations = [
        'workspace',
        'jobDetails',
        'jobDetails.profile',
        'jobDetails.profile.user',
    ];

    protected DepartmentRepository $departmentRepo;

    public function __construct(
        DepartmentRepository $repo
    ) {
        parent::__construct($repo);
        $this->departmentRepo = $repo;
    }

    /**
     * @param array $params
     * @return Department
     */
    public function createOne(array $params): Department
    {
        return $this->repo->createOne([
            'name' => $params['name'],
            'description' => $params['description'],
            'parent_id' => $params['parent_id'],
            'level' => $params['level'],
            'is_active' => true,
            'workspace_id' => $params['workspace_id'],
        ]);
    }

    /**
     * @param array $params
     * @return Department
     */
    public function createDefault(int $workspaceId, string $workspaceName): Department
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

    /**
     * @param array $params
     * @return Department|null
     */
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

    /**
     * @param int $workspaceId
     * @return array
     */
    public function getAllDepartmentWorkspace(int $workspaceId): array
    {
        $department = $this->departmentRepo->getAllDepartmentWorkspace($workspaceId);
        return $department;
    }

    /**
     * @param int $workspaceId
     * @return bool
     */
    public function deleteAllFromWorkspace(int $workspaceId): bool
    {
        return $this->departmentRepo->deleteAllFromWorkspace($workspaceId);
    }

    /**
     * Move user from one department to another
     * 
     * @param array $payload
     * @return bool
     */
    public function moveUser(array $payload): bool
    {
        return DB::transaction(function () use ($payload) {
            $fromDepartmentId = $payload['from_department_id'];
            $toDepartmentId = $payload['to_department_id'];
            $profileIds = $payload['profile_ids'];

            return $this->departmentRepo->moveUser($fromDepartmentId, $toDepartmentId, $profileIds);
        });
    }
}
