<?php

namespace App\Modules\Permission\Requests;

use App\Libraries\Crud\BaseRequest;

class PermissionStoreRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|unique:permissions,name',
            'title' => 'required|string',
            'description' => 'string',
            'status' => 'boolean',
        ];
    }
}
