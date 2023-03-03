<?php

namespace App\Modules\Adjustment;

use App\Libraries\Crud\BaseRepository;
use App\Modules\Adjustment\Adjustment;

class AdjustmentRepository extends BaseRepository
{
    public function __construct(Adjustment $adjustment)
    {
        parent::__construct($adjustment);
    }
}
