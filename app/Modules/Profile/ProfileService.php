<?php

namespace App\Modules\Profile;

use App\Libraries\Crud\BaseService;

class ProfileService extends BaseService
{
    protected array $allowedRelations = [];

    public function __construct(ProfileRepository $repo)
    {
        parent::__construct($repo);
    }

    /**
     * Create default profile for user
     *
     * @param array $user
     * @param int $workspaceId
     * @return Profile
     */
    public function createDefault(array $user, int $workspaceId): Profile
    {
        return $this->repo->createOne([
            'name' => $user['name'],
            'alias' => '',
            'avatar' => $user['avatar'] ?? null,
            'phone' => $user['phone'] ?? null,
            'email' => $user['email'] ?? null,
            'user_id' => $user['id'],
            'workspace_id' => $workspaceId,
        ]);
    }
}
