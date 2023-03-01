<?php

namespace App\Modules\Service/ApprovalService;

use App\Libraries\Crud\BaseService;

class Service/ApprovalServiceService extends BaseService
{
    protected array $allowedRelations = [];

    public function __construct(Service/ApprovalServiceRepository $repo)
    {
        parent::__construct($repo);
    }
}
