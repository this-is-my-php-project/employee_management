<?php

namespace App\Modules\Workspace\Resources;

use App\Modules\AttendanceService\Resources\AttendanceServiceResource;
use App\Modules\Department\Resources\DepartmentResource;
use App\Modules\EmployeeType\Resources\EmployeeTypeResource;
use App\Modules\JobDetail\Resources\JobDetailResource;
use App\Modules\Profile\Resources\ProfileResource;
use App\Modules\Role\Resources\RoleResource;
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
            'is_active' => $this['is_active'],
            'logo' => $this['logo'],
            'cover' => $this['cover'],
            'created_by_user' => $this['createdByUser'],
            'created_at' => $this['created_at'],
            'updated_at' => $this['updated_at'],
            'deleted_at' => $this->when($this['deleted_at'], $this['deleted_at']),
            'attendance_service' => AttendanceServiceResource::collection($this->whenLoaded('attendanceServices')),
            'roles' => RoleResource::collection($this->whenLoaded('roles')),
            'employee_types' => EmployeeTypeResource::collection($this->whenLoaded('employeeTypes')),
            'departments' => DepartmentResource::collection($this->whenLoaded('departments')),
            'job_details' => JobDetailResource::collection($this->whenLoaded('jobDetails')),
            'user_profiles' => ProfileResource::collection($this->whenLoaded('userProfiles')),
        ];
    }
}
