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
     * @return JobDetail|null
     */
    public function deleteAllFromWorkspace(string|int $workspaceId): ?JobDetail
    {
        $jobDetail = $this->model->where('workspace_id', $workspaceId)->delete();
        return $jobDetail;
    }
}
