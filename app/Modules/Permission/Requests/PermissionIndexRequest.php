<?php

namespace App\Modules\Permission\Requests;

use App\Libraries\Crud\BaseRequest;

class PermissionIndexRequest extends BaseRequest
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
            'title' => 'string',
            'description' => 'string',
            'status' => 'boolean',
        ];
    }
}
