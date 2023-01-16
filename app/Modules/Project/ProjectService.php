<?php

namespace App\Modules\Project;

use App\Libraries\Crud\BaseService;

class ProjectService extends BaseService
{
    protected array $allowedRelations = [];

    public function __construct(ProjectRepository $repo)
    {
        parent::__construct($repo);
    }
}
