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

    public function deleteAllFromWorkspace(string|int $workspaceId): ?Profile
    {
        $profile = $this->model->where('workspace_id', $workspaceId)->delete();
        return $profile;
    }
}
