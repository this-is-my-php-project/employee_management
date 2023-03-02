<?php

namespace App\Modules\Department\Requests;

use App\Libraries\Crud\BaseRequest;

class DepartmentUserRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'workspace_id' => 'required|integer',
        ];
    }
}
