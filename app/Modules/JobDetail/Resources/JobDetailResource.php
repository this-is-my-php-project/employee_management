<?php

namespace App\Modules\JobDetail\Resources;

use App\Modules\Department\Resources\DepartmentResource;
use App\Modules\EmployeeType\Resources\EmployeeTypeResource;
use App\Modules\Profile\Resources\ProfileResource;
use App\Modules\Role\Resources\RoleResource;
use App\Modules\Workspace\Resources\WorkspaceResource;
use Illuminate\Http\Resources\Json\JsonResource;

class JobDetailResource extends JsonResource
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
            'title' => $this['title'],
            'description' => $this['description'],
            'created_at' => $this['created_at'],
            'updated_at' => $this['updated_at'],
            'employee_type' => new EmployeeTypeResource($this->whenLoaded('employeeType')),
            'role' => new RoleResource($this->whenLoaded('role')),
            'department' => new DepartmentResource($this->whenLoaded('department')),
            'workspace' => new WorkspaceResource($this->whenLoaded('workspace')),
            'profile' => new ProfileResource($this->whenLoaded('profile')),
        ];
    }
}
