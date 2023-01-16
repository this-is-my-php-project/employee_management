<?php

namespace App\Modules\Role\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Modules\Permission\Resources\PermissionResource;

class RoleResource extends JsonResource
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
            'status' => $this['status'],
            'level' => $this['level'],
            'parent_id' => $this['parent_id'],
            'permissions' => PermissionResource::collection($this->whenLoaded('permissions')),
            'created_at' => $this['created_at'],
            'updated_at' => $this['updated_at'],
            'deleted_at' => $this['deleted_at'],
        ];
    }
}
