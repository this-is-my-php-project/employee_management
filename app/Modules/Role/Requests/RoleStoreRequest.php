<?php

namespace App\Modules\Role\Requests;

use App\Libraries\Crud\BaseRequest;

class RoleStoreRequest extends BaseRequest
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
            'parent_id' => 'integer|not_in:0',
            'level' => 'integer|not_in:0',
            'is_active' => 'boolean',
            'workspace_id' => 'integer|not_in:0|exists:workspaces,id',
        ];
    }
}
