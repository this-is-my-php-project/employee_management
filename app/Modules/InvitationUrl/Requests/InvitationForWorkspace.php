<?php

namespace App\Modules\InvitationUrl\Requests;

use App\Libraries\Crud\BaseRequest;

class InvitationForWorkspace extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'workspace_id' => 'required|string',
        ];
    }
}
