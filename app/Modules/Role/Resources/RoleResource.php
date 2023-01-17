<?php

namespace App\Modules\Role\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Modules\Permission\Resources\PermissionResource;
use App\Modules\User\Resources\UserResource;
use App\Modules\Workspace\Resources\WorkspaceResource;

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
            'created_at' => $this['created_at'],
            'updated_at' => $this['updated_at'],
            'deleted_at' => $this->when($this['deleted_at'], $this['deleted_at']),
            'users' => UserResource::collection($this->whenLoaded('users')),
            'workspace' => new WorkspaceResource($this->whenLoaded('workspace')),
            'permissions' => PermissionResource::collection($this->whenLoaded('permissions')),
        ];
    }
}
