<?php

namespace App\Modules\Meta;

use App\Libraries\Crud\BaseService;

class MetaService extends BaseService
{
    protected array $allowedRelations = [];

    public function __construct(MetaRepository $repo)
    {
        parent::__construct($repo);
    }
}
