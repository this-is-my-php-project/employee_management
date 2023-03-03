<?php

namespace App\Modules\AdjustmentType;

use App\Libraries\Crud\BaseService;

class AdjustmentTypeService extends BaseService
{
    protected array $allowedRelations = [];

    public function __construct(AdjustmentTypeRepository $repo)
    {
        parent::__construct($repo);
    }
}
