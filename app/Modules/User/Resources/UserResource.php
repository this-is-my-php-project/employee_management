<?php

namespace App\Modules\User\Resources;

use App\Modules\Profile\Resources\ProfileResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id' => $this['id'],
            'name' => $this['name'],
            'email' => $this['email'],
            'email_verified_at' => $this['email_verified_at'],
            'phone' => $this['phone'],
            'is_active' => $this['is_active'],
            'avatar' => $this['avatar'],
            'created_at' => $this['created_at'],
            'updated_at' => $this['updated_at'],
            'profiles' => ProfileResource::collection($this->whenLoaded('profiles')),
        ];
    }
}
