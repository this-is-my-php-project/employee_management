<?php

namespace App\Modules\Project;

use App\Libraries\Crud\BaseRepository;
use App\Modules\Project\Project;

class ProjectRepository extends BaseRepository
{
    public function __construct(Project $project)
    {
        parent::__construct($project);
    }
}
