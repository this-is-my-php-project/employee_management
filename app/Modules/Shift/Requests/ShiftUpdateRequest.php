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
            'name' => 'string|max:255',
            'clock_in' => 'string',
            'clock_out' => 'string',
        ];
    }
}
