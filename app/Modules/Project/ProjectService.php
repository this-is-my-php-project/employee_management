<?php

namespace App\Modules\Project;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Libraries\Crud\BaseService;
use App\Modules\Project\ProjectRepository;

class ProjectService extends BaseService
{
    protected array $allowedRelations = [];

    public function __construct(ProjectRepository $repo)
    {
        parent::__construct($repo);
    }

    public function createOne(array $payload): Project
    {
        return DB::transaction(function () use ($payload) {
            $payload['name'] = Str::lower(trim($payload['name']));
            $project = $this->repo->createOne([
                'name' => $payload['name'],
                'description' => $payload['description'],
                'created_by_workspace' => $payload['workspace_id'],
            ]);

            $project->workspaces()->attach($payload['workspace_id']);

            return $project;
        });
    }
}
