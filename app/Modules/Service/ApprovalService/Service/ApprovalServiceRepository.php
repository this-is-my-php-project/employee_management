<?php

namespace App\Modules\Service/ApprovalService;

use App\Libraries\Crud\BaseRepository;
use App\Modules\Service/ApprovalService\Service/ApprovalService;

class Service/ApprovalServiceRepository extends BaseRepository
{
    public function __construct(Service/ApprovalService $service/ApprovalService)
    {
        parent::__construct($service/ApprovalService);
    }
}
