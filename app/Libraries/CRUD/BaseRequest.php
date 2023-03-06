<?php

namespace App\Libraries\CRUD;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseRequest extends FormRequest
{
    /**
     * @param $validator
     * @return void
     */
    public function withValidator($validator)
    {
        if ($validator->fails()) {
            throw new HttpResponseException((new Controller())->sendError(
                'Validation Error.',
                500,
                $validator->errors()->toArray()
            ));
        }
    }
}
