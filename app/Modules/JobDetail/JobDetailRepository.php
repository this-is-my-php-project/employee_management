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
}
