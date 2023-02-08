<?php

namespace App\Modules\Workspace;

use App\Libraries\Crud\BaseService;
use App\Modules\Department\DepartmentService;
use App\Modules\EmployeeType\EmployeeTypeService;
use App\Modules\InvitationLink\InvitationLinkService;
use App\Modules\InvitationUrl\InvitationUrl;
use App\Modules\InvitationUrl\InvitationUrlService;
use App\Modules\JobDetail\JobDetailService;
use App\Modules\Meta\MetaService;
use App\Modules\Profile\ProfileService;
use App\Modules\Role\RoleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class WorkspaceService extends BaseService
{
    protected array $allowedRelations = [
        'users',
        'users.roles',
        'projects',
        'projects.workspaces',
        'roles',
        'roles.users',
        'meta',
        'employeeTypes',
        'departments',
        'jobDetails',
        'userProfiles',
    ];

    protected MetaService $metaService;
    protected RoleService $roleService;
    protected EmployeeTypeService $employeeTypeService;
    protected DepartmentService $departmentService;
    protected JobDetailService $jobDetailService;
    protected ProfileService $profileService;
    protected WorkspaceRepository $workspaceRepo;
    protected InvitationUrlService $invitationUrlService;
    public function __construct(
        WorkspaceRepository $repo,
        MetaService $metaService,
        RoleService $roleService,
        EmployeeTypeService $employeeTypeService,
        DepartmentService $departmentService,
        JobDetailService $jobDetailService,
        ProfileService $profileService,
        InvitationUrlService $invitationUrlService
    ) {
        parent::__construct($repo);
        $this->metaService = $metaService;
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

            // // create a two meta for the workspace.
            // $this->metaService->createWorkspaceMeta($workspace->id);

            /**
             * add a default role to the workspace.
             * many to many relationship.
             */
            $roleIds = $this->roleService->getRoleIds();
            $workspace->roles()->attach($roleIds);

            /**
             * add a default employee type to the workspace.
             * many to many relationship.
             */
            $employeeIds = $this->employeeTypeService->getIds();
            $workspace->employeeTypes()->attach($employeeIds);

            // create default department
            $defaultDepartment = $this->departmentService->createDefault($workspace->id, $workspace->name);

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

            // // delete workspace meta
            // $this->metaService->deleteOne($model->id);

            // remove roles from workspace
            $this->roleService->removeAllFromWorkspace($model);

            // remove employee types from workspace
            $this->employeeTypeService->removeAllFromWorkspace($model);

            // delete all departments in workspace
            $this->departmentService->deleteAllFromWorkspace($model->id);

            // delete all job details in workspace
            $this->jobDetailService->deleteAllFromWorkspace($model->id);

            // delete all profiles in workspace
            $this->profileService->deleteAllFromWorkspace($model->id);

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
            $workspaceId = decryptData($payload['workspace']);
            $departmentId = decryptData($payload['department']);

            $workspace = $this->repo->getOneOrFail($workspaceId);
            if (empty($workspace)) {
                throw new \Exception('Workspace not found');
            }

            $user = auth()->user();
            $userData = [
                'name' => $user->name,
                'avatar' => $user->avatar,
                'phone' => $user->phone,
                'email' => $user->email,
                'id' => $user->id
            ];
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
