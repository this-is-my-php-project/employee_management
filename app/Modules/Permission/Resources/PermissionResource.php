<?php

namespace App\Modules\Permission\Resources;

use App\Modules\Role\Resources\RoleResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
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
            'title' => $this['title'],
            'description' => $this['description'],
            'status' => $this['status'],
            'roles' => RoleResource::collection($this->whenLoaded('roles')),
            'created_at' => $this['created_at'],
            'updated_at' => $this['updated_at'],
            'deleted_at' => $this->when($this['deleted_at'], $this['deleted_at']),
        ];
    }
}
