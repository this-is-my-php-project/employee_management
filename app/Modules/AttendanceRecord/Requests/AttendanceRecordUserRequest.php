<?php

namespace App\Modules\AttendanceRecord\Requests;

use App\Libraries\Crud\BaseRequest;

class AttendanceRecordUserRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'workspace_id' => 'required|exists:workspaces,id',
            'profile_id' => 'required|integer|exists:profiles,id',
        ];
    }
}
