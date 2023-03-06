<?php

namespace App\Modules\Profile\Resources;

use App\Modules\JobDetail\Resources\JobDetailResource;
use App\Modules\User\Resources\UserResource;
use App\Modules\Workspace\Resources\WorkspaceResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
            'alias' => $this['alias'],
            'phone' => $this['phone'],
            'email' => $this['email'],
            'is_active' => $this['is_active'],
            'user' => new UserResource($this->whenLoaded('user')),
            'workspace' => new WorkspaceResource($this->whenLoaded('workspace')),
            'job_detail' => new JobDetailResource($this->whenLoaded('jobDetail')),
        ];
    }
}
