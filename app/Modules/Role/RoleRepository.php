<?php

namespace App\Modules\Role;

use App\Libraries\Crud\BaseRepository;
use App\Modules\Role\Constants\RoleConstants;
use App\Modules\Role\Role;

class RoleRepository extends BaseRepository
{
    public function __construct(Role $role)
    {
        parent::__construct($role);
    }

    public function getRoleIds(): array
    {
        return $this->model->where('key', '!=', RoleConstants::SUPER_ADMIN['key'])->pluck('id')->toArray();
    }

    public function getDefaultRoleIds(): int
    {
        return $this->model->where('key', RoleConstants::ADMIN['key'])->first()->id;
    }

    public function getInviteRoleId(): int
    {
        return $this->model->where('key', RoleConstants::MEMBER['key'])->first()->id;
    }
}
