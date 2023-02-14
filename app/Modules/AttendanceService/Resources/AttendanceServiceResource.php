<?php

namespace App\Modules\AttendanceService\Resources;

use App\Modules\Workspace\Resources\WorkspaceResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceServiceResource extends JsonResource
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
            'description' => $this['description'],
            'icon' => $this['icon'],
            'created_at' => $this['created_at'],
            'updated_at' => $this['updated_at'],
            'workspaces' => WorkspaceResource::collection($this->whenLoaded('workspaces')),
        ];
    }
}
