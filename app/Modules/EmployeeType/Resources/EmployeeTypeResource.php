<?php

namespace App\Modules\EmployeeType\Resources;

use App\Modules\Workspace\Resources\WorkspaceResource;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeTypeResource extends JsonResource
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
            'is_active' => $this['is_active'],
            'is_global' => $this['is_global'],
            'created_at' => $this['created_at'],
            'updated_at' => $this['updated_at'],
            'workspaces' => WorkspaceResource::collection($this->whenLoaded('workspaces')),
        ];
    }
}
