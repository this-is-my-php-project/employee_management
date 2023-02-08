<?php

namespace App\Modules\InvitationUrl;

use App\Libraries\Crud\BaseService;
use Illuminate\Support\Facades\URL;

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
            'used' => $payload['used'] ?? 0,
        ]);

        return $invitationUrl;
    }

    public function getOneInvitationUrlForWorkspace(string|int $workspaceId)
    {
        return $this->invitationUrlRepo->getOneInvitationUrlForWorkspace($workspaceId);
    }

    /**
     * Invite a user to a workspace with URL.
     * 
     * @param array $payload
     * @return string
     */
    public function generateUrl(array $payload): string
    {
        $workspaceId = encryptData($payload['workspace_id']);
        $departmentId = encryptData($payload['department_id']);
        $url = URL::temporarySignedRoute(
            'add-to-workspace',
            now()->addDays(7),
            [
                'workspace' => $workspaceId,
                'department' => $departmentId
            ]
        );
        $url_components = parse_url($url);
        parse_str($url_components['query'], $params);

        $newParams = [
            'url' => $url,
            'workspace_id' => decryptData($params['workspace']),
            'department_id' => decryptData($params['department']),
            'expires' => $params['expires'],
            'signature' => $params['signature']
        ];

        $this->createOne($newParams);

        return $url;
    }

    public function getInvitationUrl(array $payload): ?InvitationUrl
    {
        return $this->getOneInvitationUrlForWorkspace($payload['workspace_id']);
    }
}
