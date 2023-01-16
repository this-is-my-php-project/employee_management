<?php

namespace App\Modules\Workspace;

use App\Libraries\Crud\BaseService;

class WorkspaceService extends BaseService
{
    protected array $allowedRelations = [];

    public function __construct(WorkspaceRepository $repo)
    {
        parent::__construct($repo);
    }
}
