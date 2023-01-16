<?php

namespace App\Modules\Permission;

use App\Libraries\Crud\BaseRepository;
use App\Modules\Permission\Permission;

class PermissionRepository extends BaseRepository
{
    public function __construct(Permission $permission)
    {
        parent::__construct($permission);
    }
}
