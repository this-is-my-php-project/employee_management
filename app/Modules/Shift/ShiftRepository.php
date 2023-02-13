<?php

namespace App\Modules\Shift;

use App\Libraries\Crud\BaseRepository;
use App\Modules\Shift\Shift;

class ShiftRepository extends BaseRepository
{
    public function __construct(Shift $shift)
    {
        parent::__construct($shift);
    }
}
