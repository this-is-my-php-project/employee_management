<?php

namespace App\Modules\Department\Resources;

use App\Modules\JobDetail\Resources\JobDetailResource;
use App\Modules\Workspace\Resources\WorkspaceResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentResource extends JsonResource
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
            // 'parent_id' => $this['parent_id'],
            // 'level' => $this['level'],
            // 'is_active' => $this['is_active'],
            'is_default' => $this['is_default'],
            'created_at' => $this['created_at'],
            'updated_at' => $this['updated_at'],
            'deleted_at' => $this->when($this['deleted_at'], $this['deleted_at']),
            'workspace' => new WorkspaceResource($this->whenLoaded('workspace')),
            'job_details' => JobDetailResource::collection($this['jobDetails']),
        ];
    }
}
