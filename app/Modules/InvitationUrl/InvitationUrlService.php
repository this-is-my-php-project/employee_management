<?php

namespace App\Modules\InvitationUrl;

use App\Libraries\Crud\BaseService;

class InvitationUrlService extends BaseService
{
    protected array $allowedRelations = [];

    protected InvitationUrlRepository $invitationUrlRepo;
    public function __construct(
        InvitationUrlRepository $repo,
        InvitationUrlRepository $invitationUrlRepo
    ) {
        parent::__construct($repo);
        $this->invitationUrlRepo = $invitationUrlRepo;
    }

    public function createOne(array $payload): ?InvitationUrl
    {
        $invitationUrl = $this->repo->createOne([
            'workspace_id' => $payload['workspace_id'],
            'department_id' => $payload['department_id'],
            'expires' => $payload['expires'],
            'signature' => $payload['signature'],
            'url' => $payload['url'],
            'is_used' => $payload['is_used'] ?? 0,
        ]);

        return $invitationUrl;
    }

    public function getOneInvitationUrlForWorkspace(string|int $workspaceId)
    {
        return $this->invitationUrlRepo->getOneInvitationUrlForWorkspace($workspaceId);
    }
}
