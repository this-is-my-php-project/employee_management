<?php

namespace App\Modules\User;

use App\Libraries\Crud\BaseService;
use Illuminate\Support\Facades\DB;

class UserService extends BaseService
{
    /**
     * @var UserRepository
     */
    protected UserRepository $userRepository;

    /**
     * @var array
     */
    protected array $allowedRelations = [
        'roles',
        'roles.workspace',
        'roles.permissions',
        'workspaces',
        'workspaces.roles',
    ];

    /**
     * @var array
     */
    protected array $filterable = [
        'name',
        'email',
        'status',
        'password',
        'created_at',
        'updated_at'
    ];

    /**
     * constructor.
     */
    public function __construct(UserRepository $repo)
    {
        parent::__construct($repo);
        $this->userRepository = $repo;
    }

    /**
     * @param array $payload
     * @return User|null
     */
    public function createOne(array $payload): ?User
    {
        return DB::transaction(function () use ($payload) {
            $payload['password'] = bcrypt($payload['password']);
            $payload['name'] = strtolower(trim($payload['name']));
            $user = $this->userRepository->createOne($payload);

            if (!empty($payload['role_id'])) {
                $user->roles()->attach($payload['role_id']);
            }

            if (!empty($payload['workspace_id'])) {
                $user->workspaces()->attach($payload['workspace_id']);
            }

            return $user;
        });
    }

    public function updateUserRoles(int $id, array $payload): ?User
    {
        return DB::transaction(function () use ($id, $payload) {
            $user = $this->userRepository->getOne($id, []);
            $user->roles()->sync($payload['role_id']);

            return $user;
        });
    }
}
