<?php

namespace App\Modules\Profile\Requests;

use App\Libraries\Crud\BaseRequest;

class ProfileGetRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'workspace_id' => 'required|exists:workspaces,id,deleted_at,NULL',
            'name' => 'nullable|string',
            'alias' => 'nullable|string',
        ];
    }
}
