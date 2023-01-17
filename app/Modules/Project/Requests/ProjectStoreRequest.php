<?php

namespace App\Modules\Project\Requests;

use App\Libraries\Crud\BaseRequest;

class ProjectStoreRequest extends BaseRequest
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
            'description' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'workspace_id' => 'required|integer|exists:workspaces,id'
        ];
    }
}
