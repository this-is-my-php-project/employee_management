<?php

namespace App\Modules\InvitationUrl;

use App\Libraries\Crud\BaseRepository;
use App\Modules\InvitationUrl\InvitationUrl;

class InvitationUrlRepository extends BaseRepository
{
    public function __construct(InvitationUrl $invitationUrl)
    {
        parent::__construct($invitationUrl);
    }

    /**
     * Get the latest invitation url for a workspace.
     * 
     * @param string|int $workspaceId
     * @return InvitationUrl|null
     */
    public function getOneInvitationUrlForWorkspace(string|int $workspaceId)
    {
        return $this->model
            ->where('workspace_id', $workspaceId)
            ->orderBy('created_at', 'desc')
            ->first();
    }

    /**
     * Get the url by signature.
     * 
     * @param string $signature
     * @return InvitationUrl|null
     */
    public function getUrlBySignature(string $signature): ?InvitationUrl
    {
        return $this->model
            ->where('signature', $signature)
            ->first();
    }

    /**
     * Reset the url for a workspace.
     * 
     * @param string|int $workspaceId
     * @return bool
     */
    public function resetUrlForWorkspace(string|int $workspaceId): bool
    {
        return $this->model
            ->where('workspace_id', $workspaceId)
            ->update(['force_expired' => 1]);
    }
}
