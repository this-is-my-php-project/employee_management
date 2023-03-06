<?php

namespace App\Modules\Profile\Requests;

use App\Libraries\Crud\BaseRequest;

class ProfileUpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'string|max:255',
            'alias' => 'nullable|string|max:255',
            'avatar' => 'nullable|string|max:255',
            'workspace_id' => 'required'
        ];
    }
}
