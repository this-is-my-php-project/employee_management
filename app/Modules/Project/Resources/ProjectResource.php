<?php

namespace App\Modules\Project\Resources;

use App\Modules\CreateBy\Resources\CreateByResource;
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
            'created_at' => $this['created_at'],
            'updated_at' => $this['updated_at'],
            'deleted_at' => $this->when($this['deleted_at'], $this['deleted_at']),
            'created_by_workspace' => new CreateByResource($this['createdByWorkspace']),
            'workspace' => WorkspaceResource::collection($this->whenLoaded('workspace')),
            'users' => UserResource::collection($this->whenLoaded('users')),
        ];
    }
}
