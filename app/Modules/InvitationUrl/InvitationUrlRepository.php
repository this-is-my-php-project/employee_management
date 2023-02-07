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

    public function getOneInvitationUrlForWorkspace(string|int $workspaceId)
    {
        return $this->model->where('workspace_id', $workspaceId)->orderBy('created_at', 'desc')->first();
    }
}
