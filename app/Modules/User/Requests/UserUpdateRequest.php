<?php

namespace App\Modules\User\Requests;

use App\Libraries\Crud\BaseRequest;

class UserUpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password' => 'string',
            'name' => 'string',
            'status' => 'boolean',
            'role_id' => 'array',
        ];
    }
}
