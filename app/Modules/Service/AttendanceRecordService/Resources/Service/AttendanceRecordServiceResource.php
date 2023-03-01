<?php

namespace App\Modules\Service/AttendanceRecordService\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Service/AttendanceRecordServiceResource extends JsonResource
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
