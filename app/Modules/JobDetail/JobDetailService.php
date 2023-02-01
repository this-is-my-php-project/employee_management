<?php

namespace App\Modules\JobDetail;

use App\Libraries\Crud\BaseService;

class JobDetailService extends BaseService
{
    protected array $allowedRelations = [];

    public function __construct(JobDetailRepository $repo)
    {
        parent::__construct($repo);
    }
}
