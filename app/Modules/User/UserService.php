<?php

namespace App\Modules\User;

use App\Libraries\Crud\BaseService;

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
        'roles.permissions'
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

        $payload['password'] = bcrypt($payload['password']);

        $user = $this->userRepository->createOne($payload);
        return $user;
    }
}
