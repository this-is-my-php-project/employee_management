<?php

namespace App\Modules\EmployeeType\Requests;

use App\Libraries\Crud\BaseRequest;

class EmployeeTypeUserRequest extends BaseRequest
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
