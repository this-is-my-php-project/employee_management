<?php

namespace App\Modules\Shift\Requests;

use App\Libraries\Crud\BaseRequest;

class ShiftStoreRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'clock_in' => 'required|date_format:H:i',
            'clock_out' => 'required|date_format:H:i',
            'name' => 'required|string',
            'workspace_id' => 'required|integer|exists:workspaces,id',
        ];
    }
}
