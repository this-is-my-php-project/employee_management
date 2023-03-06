<?php

namespace App\Modules\Workspace;

use App\Libraries\Crud\BaseService;
use App\Modules\Department\DepartmentService;
use App\Modules\EmployeeType\EmployeeTypeService;
use App\Modules\InvitationUrl\InvitationUrlService;
use App\Modules\JobDetail\JobDetailService;
use App\Modules\Profile\ProfileService;
use App\Modules\Role\RoleService;
use Illuminate\Support\Facades\DB;

class WorkspaceService extends BaseService
{
    protected array $allowedRelations = [
        'users',
        'users.roles',
        'projects',
        'projects.workspaces',
        'roles',
        'roles.users',
        'employeeTypes',
        'departments',
        'jobDetails',
        'userProfiles',
    ];

    protected RoleService $roleService;
    protected EmployeeTypeService $employeeTypeService;
    protected DepartmentService $departmentService;
    protected JobDetailService $jobDetailService;
    protected ProfileService $profileService;
    protected WorkspaceRepository $workspaceRepo;
    protected InvitationUrlService $invitationUrlService;
    public function __construct(
        WorkspaceRepository $repo,
        RoleService $roleService,
        EmployeeTypeService $employeeTypeService,
        DepartmentService $departmentService,
        JobDetailService $jobDetailService,
        ProfileService $profileService,
        InvitationUrlService $invitationUrlService
    ) {
        parent::__construct($repo);
        $this->roleService = $roleService;
        $this->employeeTypeService = $employeeTypeService;
        $this->departmentService = $departmentService;
        $this->jobDetailService = $jobDetailService;
        $this->profileService = $profileService;
        $this->workspaceRepo = $repo;
        $this->invitationUrlService = $invitationUrlService;
    }

    /**
     * Create a workspace.
     * 
     * @param array $payload
     * @return Workspace
     */
    public function createOne(array $payload): Workspace
    {
        return DB::transaction(function () use ($payload) {
            $user = auth()->user();
            // create a workspace.
            $payload['name'] = strtolower(trim($payload['name']));
            $workspace = $this->repo->createOne([
                'name' => $payload['name'],
                'description' => $payload['description'] ?? $payload['name'],
                'is_active' => true,
                'logo' => $payload['logo'] ?? null,
                'cover' => $payload['cover'] ?? null,
                'created_by_user' => auth()->user()->id
            ]);

            // create default department
            $defaultDepartment = $this->departmentService->createDefault(
                $workspace->id,
                $workspace->name
            );

            // create new user data
            $userData = [
                'name' => $user->name,
                'avatar' => $user->avatar,
                'phone' => $user->phone,
                'email' => $user->email,
                'id' => $user->id
            ];

            // create workspace profile for user
            $profile = $this->profileService->createDefault(
                $userData,
                $workspace->id
            );

            $defaultRole = $this->roleService->getDefaultRoleIds();
            $defaultEmployeeId = $this->employeeTypeService->getDefaultEmployeeId();
            $defaultDepartmentId = $defaultDepartment->id;

            // create default job details
            $this->jobDetailService->createDefault(
                $workspace->id,
                $defaultEmployeeId,
                $defaultRole,
                $defaultDepartmentId,
                $profile->id
            );

            return $workspace;
        });
    }

    /**
     * Delete a workspace.
     * 
     * @param string|int $id
     * @return Workspace
     */
    public function deleteOne(string|int $id): ?Workspace
    {
        return DB::transaction(function () use ($id) {
            $model = $this->repo->getOneOrFail($id);

            // delete all departments in workspace
            $this->departmentService->deleteMultipleByField('workspace_id', $model->id);
            // delete all job details in workspace
            $this->jobDetailService->deleteMultipleByField('workspace_id', $model->id);

            // delete all profiles in workspace
            $this->profileService->deleteMultipleByField('workspace_id', $model->id);

            // delete workspace
            $workspace = $this->repo->deleteOne($model);

            return $workspace;
        });
    }

    /**
     * Add a user to a workspace.
     * 
     * @param array $payload
     * @return Workspace
     */
    public function addToWorkspace(array $payload): Workspace
    {
        return DB::transaction(function () use ($payload) {
            $user = auth()->user();
            $userData = [
                'name' => $user->name,
                'avatar' => $user->avatar,
                'phone' => $user->phone,
                'email' => $user->email,
                'id' => $user->id
            ];

            $workspaceId = decryptData($payload['workspace']);
            $departmentId = decryptData($payload['department']);

            $workspace = $this->repo->getOneOrFail($workspaceId);
            if (empty($workspace)) {
                throw new \Exception('Workspace not found');
            }

            if (!empty($this->profileService->getOneByWorkspace($user->id, $workspaceId))) {
                throw new \Exception('You are already joined in this workspace');
            }

            $profile = $this->profileService->createDefault(
                $userData,
                $workspaceId
            );

            $inviteRoleId = $this->roleService->getInviteRoleId();
            $inviteEmployeeId = $this->employeeTypeService->getInviteEmployeeId();
            $this->jobDetailService->createDefault(
                $workspaceId,
                $inviteEmployeeId,
                $inviteRoleId,
                $departmentId,
                $profile->id
            );

            return $workspace;
        });
    }

    /**
     * Get my workspaces.
     * 
     * @return Workspace
     */
    public function myWorkspaces()
    {
        $userId = auth()->user()->id;
        $workspaces = $this->workspaceRepo->myWorkspaces($userId);
        return $workspaces;
    }
}
