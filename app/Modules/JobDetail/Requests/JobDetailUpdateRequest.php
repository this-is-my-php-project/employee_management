<?php

namespace App\Modules\JobDetail\Requests;

use App\Libraries\Crud\BaseRequest;

class JobDetailUpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'string|max:255',
            'description' => 'string|max:255',
            'employee_type_id' => 'integer|exists:employee_types,id',
            'role_id' => 'integer|exists:roles,id',
            'department_id' => 'integer|exists:departments,id',
        ];
    }
}
