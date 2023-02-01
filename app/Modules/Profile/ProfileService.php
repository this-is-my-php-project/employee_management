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

    public function createDefault(array $user, int $jobDetailId, int $workspaceId): Profile
    {
        return $this->repo->createOne([
            'name' => $user['name'],
            'alias' => '',
            'avatar' => $user['avatar'] ?? null,
            'phone' => $user['phone'] ?? null,
            'email' => $user['email'] ?? null,
            'job_detail_id' => $jobDetailId,
            'user_id' => $user['id'],
            'workspace_id' => $workspaceId,
        ]);
    }
}
