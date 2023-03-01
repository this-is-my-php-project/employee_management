<?php

namespace App\Modules\Service/ShiftService;

use App\Libraries\Crud\BaseRepository;
use App\Modules\Service/ShiftService\Service/ShiftService;

class Service/ShiftServiceRepository extends BaseRepository
{
    public function __construct(Service/ShiftService $service/ShiftService)
    {
        parent::__construct($service/ShiftService);
    }
}
