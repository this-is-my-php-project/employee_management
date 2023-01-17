<?php

namespace App\Modules\User\Requests;

use App\Libraries\Crud\BaseRequest;

class UserStoreRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'name' => 'required|string',
            'status' => 'boolean',
            'workspace_id' => 'required|integer|exists:workspaces,id',
            'role_id' => 'integer|exists:roles,id',
        ];
    }
}
