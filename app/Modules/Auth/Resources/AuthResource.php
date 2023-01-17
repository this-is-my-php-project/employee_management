<?php

namespace App\Modules\Auth\Resources;

use App\Modules\User\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'token' => $this['token'],
            'user' => new UserResource($this['user'])
        ];
    }
}
