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
            'name' => 'required|string|max:255',
            'clock_in' => 'required|string',
            'clock_out' => 'required|string',
            'workspace_id' => 'required|integer|exists:workspaces,id',
        ];
    }
}
