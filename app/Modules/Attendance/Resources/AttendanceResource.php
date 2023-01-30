<?php

namespace App\Modules\Attendance\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
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
            'start_date' => $this['start_date'],
            'start_time' => $this['start_time'],
            'end_date' => $this['end_date'],
            'end_time' => $this['end_time'],
            'status' => $this['status'],
            'user_id' => $this['user_id'],
            'workspace_id' => $this['workspace_id'],
            'created_at' => $this['created_at'],
            'updated_at' => $this['updated_at'],
        ];
    }
}
