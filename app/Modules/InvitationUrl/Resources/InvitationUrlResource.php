<?php

namespace App\Modules\InvitationUrl\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvitationUrlResource extends JsonResource
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
            'workspace_id' => $this['workspace_id'],
            'department_id' => $this['department_id'],
            'expires' => $this['expires'],
            'signature' => $this['signature'],
            'url' => $this['url'],
            'used' => $this['used'],
            'force_expired' => $this['force_expired'],
            'created_at' => $this['created_at'],
            'updated_at' => $this['updated_at'],
        ];
    }
}
