<?php

namespace App\Modules\Workspace;

use App\Libraries\Crud\BaseRepository;
use App\Modules\Workspace\Workspace;

class WorkspaceRepository extends BaseRepository
{
    public function __construct(Workspace $workspace)
    {
        parent::__construct($workspace);
    }
}
