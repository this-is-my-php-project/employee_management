<?php

namespace App\Modules\Department\Requests;

use App\Libraries\Crud\BaseRequest;

class MoveUserRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'from_department_id' => 'required|integer',
            'to_department_id' => 'required|integer',
            'profile_ids' => 'array',
            'workspace_id' => 'required|exists:workspaces,id,deleted_at,NULL',
        ];
    }
}
