<?php

namespace App\Modules\Workspace\Requests;

use App\Libraries\Crud\BaseRequest;

class WorkspaceInviteRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'workspace_id' => 'required|integer|exists:workspaces,id',
            'department_id' => 'required|integer|exists:departments,id',
        ];
    }
}
