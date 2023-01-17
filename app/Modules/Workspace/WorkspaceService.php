<?php

namespace App\Modules\Workspace;

use App\Libraries\Crud\BaseService;
use App\Modules\Auth\AuthService;
use App\Modules\Role\RoleRepository;
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
    ];

    protected RoleRepository $roleRepo;

    public function __construct(
        WorkspaceRepository $repo,
        RoleRepository $roleRepo
    ) {
        parent::__construct($repo);
        $this->roleRepo = $roleRepo;
    }

    public function createOne(array $payload): Workspace
    {
        return DB::transaction(function () use ($payload) {
            /**
             * create a workspace.
             */
            $payload['name'] = strtolower(trim($payload['name']));
            $workspace = $this->repo->createOne([
                'name' => $payload['name'],
                'description' => $payload['description'] ?? $payload['name'],
                'status' => true,
                'created_by_user' => auth()->user()->id
            ]);

            /**
             * create a role and add role to the workspace.
             */
            $role = $this->roleRepo->createOne([
                'name' => 'admin',
                'description' => 'This is the default admin role for the workspace. It has all the permissions.',
                'status' => true,
                'level' => 1,
                'parent_id' => 0,
                'workspace_id' => $workspace->id,
                'created_by_user' => auth()->user()->id
            ]);

            /**
             * add a role and workspace to the user.
             * role is get from workspace and if user have role means user is in workspace.
             */
            $user = AuthService::getAuthUser();
            $user->roles()->attach($role->id);
            $user->workspaces()->attach($workspace->id);

            return $workspace;
        });
    }
}
