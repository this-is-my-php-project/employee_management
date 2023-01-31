<?php

namespace App\Modules\Attendance\Requests;

use App\Libraries\Crud\BaseRequest;

class AttendanceStoreRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'timezone' => 'string',
            'start_date' => 'date',
            'end_date' => 'date',
            'start_time' => 'date_format:H:i:s',
            'end_time' => 'date_format:H:i:s',
            'status' => 'boolean',
            'workspace_id' => 'required|integer',
        ];
    }
}
