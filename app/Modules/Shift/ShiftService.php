<?php

namespace App\Modules\Shift;

use App\Libraries\Crud\BaseService;

class ShiftService extends BaseService
{
    protected array $allowedRelations = [];

    public function __construct(ShiftRepository $repo)
    {
        parent::__construct($repo);
    }
}
