<?php

namespace App\Modules\Adjust;

use App\Libraries\Crud\BaseService;

class AdjustService extends BaseService
{
    protected array $allowedRelations = [];

    public function __construct(AdjustRepository $repo)
    {
        parent::__construct($repo);
    }
}
