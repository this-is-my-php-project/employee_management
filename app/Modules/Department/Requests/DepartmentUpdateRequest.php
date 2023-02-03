<?php

namespace App\Modules\Department\Requests;

use App\Libraries\Crud\BaseRequest;

class DepartmentUpdateRequest extends BaseRequest
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
        ];
    }
}
