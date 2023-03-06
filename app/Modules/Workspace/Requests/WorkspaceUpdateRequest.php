<?php

namespace App\Modules\Workspace\Requests;

use App\Libraries\Crud\BaseRequest;

class WorkspaceUpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'string',
            'description' => 'string',
            // 'logo' => 'file',
            // 'cover' => 'file',
        ];
    }
}
