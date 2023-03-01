<?php

namespace App\Modules\Service;

use App\Libraries\Crud\BaseRepository;
use App\Modules\Service\Service;

class ServiceRepository extends BaseRepository
{
    public function __construct(Service $service)
    {
        parent::__construct($service);
    }
}
