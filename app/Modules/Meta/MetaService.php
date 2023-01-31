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

    /**
     * Create meta for a workspace.
     *
     * @param int $workspaceId
     * @return array
     */
    public function createWorkspaceMeta(int $workspaceId): array
    {
        return $this->repo->createMany([
            [
                'key' => 'start_time',
                'value' => '8:00',
                'name' => 'start time',
                'workspace_id' => $workspaceId
            ],
            [
                'key' => 'end_time',
                'value' => '17:00',
                'name' => 'end time',
                'workspace_id' => $workspaceId
            ]
        ]);
    }
}
