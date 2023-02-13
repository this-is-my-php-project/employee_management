<?php

namespace App\Modules\UserAttendanceMeta\Requests;

use App\Libraries\Crud\BaseRequest;

class UserAttendanceMetaStoreRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'clock_in' => 'required|string',
            'clock_out' => 'required|string',
            'workspace_id' => 'required|integer',
            'job_detail_id' => 'required|string',
        ];
    }
}
