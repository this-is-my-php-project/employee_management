<?php

namespace App\Modules\InvitationUrl\Requests;

use App\Libraries\Crud\BaseRequest;

class InvitationUrlUpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'force_expired' => 'boolean',
        ];
    }
}
