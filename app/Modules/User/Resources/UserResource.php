<?php

namespace App\Modules\User\Resources;

use App\Modules\CreateBy\Resources\CreateByResource;
use App\Modules\Role\Resources\RoleResource;
use App\Modules\Workspace\Resources\WorkspaceResource;
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
            'status' => $this['status'],
            'storage_id' => $this['storage_id'],
            'created_at' => $this['created_at'],
            'updated_at' => $this['updated_at'],
            'deleted_at' => $this->when($this['deleted_at'], $this['deleted_at']),
            'roles' => RoleResource::collection($this->whenLoaded('roles')),
            'workspaces' => WorkspaceResource::collection($this->whenLoaded('workspaces')),
        ];
    }
}
