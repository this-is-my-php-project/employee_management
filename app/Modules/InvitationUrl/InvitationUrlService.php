<?php

namespace App\Modules\InvitationUrl;

use App\Libraries\Crud\BaseService;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;

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

    /**
     * Get invitation url
     * 
     * @param array $payload
     * @return InvitationUrl|null
     */
    public function getInvitationUrlForWorkspace(array $payload): ?InvitationUrl
    {
        return $this->invitationUrlRepo
            ->getOneInvitationUrlForWorkspace($payload['workspace_id']);
    }

    /**
     * Validate invitation url
     * 
     * @param Request $request
     * @return bool
     */
    public function validateUrl(Request $request): bool
    {
        $signature = $request->signature;
        $url = $this->getUrlBySignature($signature);

        if (empty($url)) {
            abort(401, 'Invalid URL');
        }

        if (!empty($url)) {
            if (!empty($url->force_expired)) {
                abort(401, 'URL has expired');
            }
        }

        if (!$request->hasValidSignature()) {
            abort(401, 'Invalid URL');
        }

        return true;
    }

    /**
     * Get invitation url by signature
     * 
     * @param string $signature
     * @return InvitationUrl|null
     */
    public function getUrlBySignature(string $signature): ?InvitationUrl
    {
        return $this->invitationUrlRepo
            ->getUrlBySignature($signature);
    }

    /**
     * Reset invitation url
     * 
     * @param string|int $workspaceId
     * @return bool
     */
    public function resetInvitationUrl(string|int $workspaceId): bool
    {
        return $this->invitationUrlRepo
            ->resetUrlForWorkspace($workspaceId);
    }
}
