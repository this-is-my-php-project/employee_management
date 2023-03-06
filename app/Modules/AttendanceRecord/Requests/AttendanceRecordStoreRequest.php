<?php

namespace App\Modules\AttendanceRecord\Requests;

use App\Libraries\Crud\BaseRequest;

class AttendanceRecordStoreRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'clock_in' => 'required|date_format:H:i:s',
            'clock_out' => 'required|date_format:H:i:s',
            'workspace_id' => 'required|integer|exists:workspaces,id',
        ];
    }
}
