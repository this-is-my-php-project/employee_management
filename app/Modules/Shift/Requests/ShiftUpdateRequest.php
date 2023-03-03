<?php

namespace App\Modules\Shift\Requests;

use App\Libraries\Crud\BaseRequest;

class ShiftUpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'clock_in' => 'date_format:H:i',
            'clock_out' => 'date_format:H:i',
            'name' => 'string',
        ];
    }
}
