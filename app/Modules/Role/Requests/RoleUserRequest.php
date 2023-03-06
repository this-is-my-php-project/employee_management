<?php

namespace App\Modules\Role\Requests;

use App\Libraries\Crud\BaseRequest;

class RoleUserRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'workspace_id' => 'required|exists:workspaces,id,deleted_at,NULL',
        ];
    }
}
