<?php

namespace App\Modules\UserAttendanceMeta\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserAttendanceMetaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
