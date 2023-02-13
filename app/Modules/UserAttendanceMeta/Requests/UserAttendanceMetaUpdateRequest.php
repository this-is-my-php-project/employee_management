<?php

namespace App\Modules\UserAttendanceMeta\Requests;

use App\Libraries\Crud\BaseRequest;

class UserAttendanceMetaUpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'clock_in' => 'string',
            'clock_out' => 'string'
        ];
    }
}
