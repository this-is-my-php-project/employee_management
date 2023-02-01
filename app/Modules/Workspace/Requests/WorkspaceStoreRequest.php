<?php

namespace App\Modules\Workspace\Requests;

use App\Libraries\Crud\BaseRequest;

class WorkspaceStoreRequest extends BaseRequest
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
            'description' => 'string|max:255',
            'logo' => 'file|image|max:1024',
            'cover' => 'file|image|max:1024',
        ];
    }
}
