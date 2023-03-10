<?php

namespace App\Modules\Role\Requests;

use App\Libraries\Crud\BaseRequest;

class RoleUpdateRequest extends BaseRequest
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
            'status' => 'boolean',
            'level' => 'integer|not_in:0',
            'parent_id' => 'integer|not_in:0',
        ];
    }
}
