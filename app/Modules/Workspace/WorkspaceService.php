<?php

namespace App\Modules\Workspace;

use App\Libraries\Crud\BaseService;
use App\Modules\Auth\AuthService;
use App\Modules\Meta\MetaRepository;
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

    protected MetaRepository $metaRepo;

    public function __construct(
        WorkspaceRepository $repo,
        RoleRepository $roleRepo,
        MetaRepository $metaRepo
    ) {
        parent::__construct($repo);
        $this->roleRepo = $roleRepo;
        $this->metaRepo = $metaRepo;
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
             * create a two meta for the workspace.
             */
            $this->metaRepo->createMany(
                [
                    'key' => 'start_time',
                    'value' => null,
                    'name' => 'start time',
                    'workspace_id' => $workspace->id
                ],
                [
                    'key' => 'end_time',
                    'value' => null,
                    'name' => 'end time',
                    'workspace_id' => $workspace->id
                ]
            );

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
                'created_by_workspace' => $workspace->id
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
