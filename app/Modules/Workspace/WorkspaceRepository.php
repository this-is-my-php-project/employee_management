<?php

namespace App\Modules\Workspace;

use App\Libraries\Crud\BaseRepository;
use App\Modules\Workspace\Workspace;

class WorkspaceRepository extends BaseRepository
{
    public function __construct(Workspace $workspace)
    {
        parent::__construct($workspace);
    }

    public function myWorkspaces($userId)
    {
        return $this->model->whereHas('userProfiles', function ($query) use ($userId) {
            $query->where('profiles.user_id', $userId);
        })->with([
            'roles',
            'employeeTypes',
            'departments',
            'jobDetails',
            'userProfiles',
        ])->get();
    }
}
