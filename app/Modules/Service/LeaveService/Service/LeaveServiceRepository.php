<?php

namespace App\Modules\Service/LeaveService;

use App\Libraries\Crud\BaseRepository;
use App\Modules\Service/LeaveService\Service/LeaveService;

class Service/LeaveServiceRepository extends BaseRepository
{
    public function __construct(Service/LeaveService $service/LeaveService)
    {
        parent::__construct($service/LeaveService);
    }
}
