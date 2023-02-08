<?php

namespace App\Modules\InvitationUrl\Requests;

use App\Libraries\Crud\BaseRequest;

class InvitationUrlStoreRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'workspace_id' => 'required|integer',
            'department_id' => 'required|integer',
        ];
    }
}
