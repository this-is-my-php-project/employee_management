<?php

namespace App\Modules\AdjustmentType;

use App\Libraries\Crud\BaseRepository;
use App\Modules\AdjustmentType\AdjustmentType;

class AdjustmentTypeRepository extends BaseRepository
{
    public function __construct(AdjustmentType $adjustmentType)
    {
        parent::__construct($adjustmentType);
    }
}
