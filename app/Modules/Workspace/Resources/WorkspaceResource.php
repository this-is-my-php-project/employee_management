<?php

namespace App\Modules\Workspace\Resources;

use App\Modules\CreateBy\Resources\CreateByResource;
use App\Modules\Project\Resources\ProjectResource;
use App\Modules\Role\Resources\RoleResource;
use App\Modules\User\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkspaceResource extends JsonResource
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
            'created_at' => $this['created_at'],
            'updated_at' => $this['updated_at'],
            'deleted_at' => $this->when($this['deleted_at'], $this['deleted_at']),
            'created_by_user' => new CreateByResource($this['createdByUser']),
            'users' => UserResource::collection($this->whenLoaded('users')),
            'projects' => ProjectResource::collection($this->whenLoaded('projects')),
            'roles' => RoleResource::collection($this->whenLoaded('roles')),
        ];
    }
}
