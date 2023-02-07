<?php

namespace App\Modules\JobDetail;

use App\Libraries\Crud\BaseRepository;
use App\Modules\JobDetail\JobDetail;

class JobDetailRepository extends BaseRepository
{
    public function __construct(JobDetail $jobDetail)
    {
        parent::__construct($jobDetail);
    }

    /**
     * Delete all job details from workspace
     *
     * @param string|int $workspaceId
     * @return bool
     */
    public function deleteAllFromWorkspace(string|int $workspaceId): bool
    {
        return $this->model->where('workspace_id', $workspaceId)->delete();
    }
}
