<?php

namespace App\Modules\Adjust;

use App\Libraries\Crud\BaseRepository;
use App\Modules\Adjust\Adjust;

class AdjustRepository extends BaseRepository
{
    public function __construct(Adjust $adjust)
    {
        parent::__construct($adjust);
    }
}
