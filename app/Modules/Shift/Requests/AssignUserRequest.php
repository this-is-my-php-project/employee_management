<?php

namespace App\Modules\Shift\Requests;

use App\Libraries\Crud\BaseRequest;

class AssignUserRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'shift_id' => 'required|integer|exists:shifts,id',
            'job_detail_ids' => 'required|array',
            'workspace_id' => 'required|exists:workspaces,id,deleted_at,NULL',
        ];
    }
}
