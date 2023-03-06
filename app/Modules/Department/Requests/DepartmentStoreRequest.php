<?php

namespace App\Modules\Department\Requests;

use App\Libraries\Crud\BaseRequest;

class DepartmentStoreRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'description' => 'string',
            'level' => 'required|integer',
            'parent_id' => 'required|integer',
            'workspace_id' => 'required|exists:workspaces,id,deleted_at,NULL',
        ];
    }
}
