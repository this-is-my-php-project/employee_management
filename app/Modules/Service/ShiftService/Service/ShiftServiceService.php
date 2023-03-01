<?php

namespace App\Modules\Service/ShiftService;

use App\Libraries\Crud\BaseService;

class Service/ShiftServiceService extends BaseService
{
    protected array $allowedRelations = [];

    public function __construct(Service/ShiftServiceRepository $repo)
    {
        parent::__construct($repo);
    }
}
