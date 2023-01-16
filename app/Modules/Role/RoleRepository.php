<?php

namespace App\Modules\Role;

use App\Libraries\Crud\BaseRepository;
use App\Modules\Role\Role;

class RoleRepository extends BaseRepository
{
    public function __construct(Role $role)
    {
        parent::__construct($role);
    }
}
