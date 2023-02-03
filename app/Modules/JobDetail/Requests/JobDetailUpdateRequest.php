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
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'employee_type_id' => 'required|integer|exists:employee_types,id',
            'role_id' => 'required|integer|exists:roles,id',
            'department_id' => 'required|integer|exists:departments,id',
        ];
    }
}
