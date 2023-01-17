<?php

namespace App\Modules\Auth\Requests;

use App\Libraries\Crud\BaseRequest;

class AuthStoreRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|ends_with:@gmail.com',
            'password' => 'required',
            'name' => 'required',
        ];
    }
}
