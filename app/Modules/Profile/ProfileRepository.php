<?php

namespace App\Modules\Profile;

use App\Libraries\Crud\BaseRepository;
use App\Modules\Profile\Profile;

class ProfileRepository extends BaseRepository
{
    public function __construct(Profile $profile)
    {
        parent::__construct($profile);
    }

    public function deleteAllFromWorkspace(string|int $workspaceId): bool
    {
        return $this->model
            ->where('workspace_id', $workspaceId)
            ->delete();
    }

    public function getOneByWorkspace(string|int $userId, string|int $workspaceId): ?Profile
    {
        return $this->model
            ->where('user_id', $userId)
            ->where('workspace_id', $workspaceId)
            ->first();
    }
}
