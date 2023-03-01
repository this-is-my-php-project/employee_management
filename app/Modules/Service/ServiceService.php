<?php

namespace App\Modules\Service;

use App\Libraries\Crud\BaseService;

class ServiceService extends BaseService
{
    protected array $allowedRelations = [];

    public function __construct(ServiceRepository $repo)
    {
        parent::__construct($repo);
    }
}
