<?php

namespace App\Modules\JobDetail;

use App\Libraries\Crud\BaseService;
use App\Modules\Role\Constants\RoleConstants;

class JobDetailService extends BaseService
{
    protected array $allowedRelations = [
        'employeeType',
        'role',
        'department',
        'workspace',
        'profile',
    ];
    protected JobDetailRepository $jobDetailRepo;

    public function __construct(JobDetailRepository $repo)
    {
        parent::__construct($repo);
        $this->jobDetailRepo = $repo;
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
            'profile_id' => $payload['profile_id'],
        ]);
    }

    /**
     * Create default job detail for workspace
     *
     * @param int $workspaceId
     * @param int $employeeTypeId
     * @param int $roleId
     * @param int $departmentId
     * @param int $profileId
     * @return JobDetail
     */
    public function createDefault(
        int $workspaceId,
        int $employeeTypeId,
        int $roleId,
        int $departmentId,
        int $profileId
    ) {
        return $this->repo->createOne([
            'title' => 'Default',
            'description' => 'Default job detail for workspace id ' . $workspaceId,
            'employee_type_id' => $employeeTypeId,
            'role_id' => $roleId,
            'department_id' => $departmentId,
            'workspace_id' => $workspaceId,
            'profile_id' => $profileId,
        ]);
    }

    /**
     * Delete a job detail
     * 
     * @param string|int $id
     * @return JobDetail|null
     */
    public function deleteOne(string|int $id): ?JobDetail
    {
        $jobDetail = $this->repo->getOneOrFail($id, []);

        if ($jobDetail->profile()->count() > 0) {
            throw new \Exception('Job detail is in use. Delete profile first');
        }
        return $this->repo->deleteOne($jobDetail);
    }

    /**
     * Delete all job details from workspace
     *
     * @param string|int $workspaceId
     * @return bool
     */
    public function deleteAllFromWorkspace(string|int $workspaceId): bool
    {
        return $this->jobDetailRepo->deleteAllFromWorkspace($workspaceId);
    }
}
