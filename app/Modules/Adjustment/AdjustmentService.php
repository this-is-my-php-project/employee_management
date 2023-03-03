<?php

namespace App\Modules\Adjustment;

use App\Libraries\Crud\BaseService;

class AdjustmentService extends BaseService
{
    protected array $allowedRelations = [];

    public function __construct(AdjustmentRepository $repo)
    {
        parent::__construct($repo);
    }
}
