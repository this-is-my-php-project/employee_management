<?php

namespace App\Modules\User\Requests;

use App\Libraries\Crud\BaseRequest;

class UserIndexRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'string|email',
            'name' => 'string',
            'status' => 'boolean',
            'phone' => 'string',
        ];
    }
}
