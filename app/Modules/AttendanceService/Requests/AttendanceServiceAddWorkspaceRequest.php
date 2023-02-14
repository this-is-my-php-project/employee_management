<?php

namespace App\Modules\AttendanceService\Requests;

use App\Libraries\Crud\BaseRequest;

class AttendanceServiceAddWorkspaceRequest extends BaseRequest
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
        ];
    }
}
