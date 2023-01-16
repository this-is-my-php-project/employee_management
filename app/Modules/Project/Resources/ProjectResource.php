<?php

namespace App\Modules\Project\Resources;

use App\Modules\User\Resources\UserResource;
use App\Modules\Workspace\Resources\WorkspaceResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'workspaces' => WorkspaceResource::collection($this->whenLoaded('workspaces')),
            'users' => UserResource::collection($this->whenLoaded('users')),
            'created_at' => $this['created_at'],
            'updated_at' => $this['updated_at'],
            'deleted_at' => $this['deleted_at'],
        ];
    }
}
