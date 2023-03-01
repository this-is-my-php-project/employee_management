<?php

namespace App\Modules\Service/LeaveService;

use App\Libraries\Crud\BaseService;

class Service/LeaveServiceService extends BaseService
{
    protected array $allowedRelations = [];

    public function __construct(Service/LeaveServiceRepository $repo)
    {
        parent::__construct($repo);
    }
}
