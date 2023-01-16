<?php

namespace App\Modules\Role;

use App\Libraries\Crud\BaseService;

class RoleService extends BaseService
{
    /**
     * @var array
     */
    protected array $allowedRelations = [
        'permissions',
        'users'
    ];

    /**
     * @var array
     */
    protected array $filterable = [
        'name',
        'description',
        'status',
        'level',
        'created_at',
        'updated_at'
    ];

    /**
     * constructor.
     */
    public function __construct(RoleRepository $repo)
    {
        parent::__construct($repo);
    }
}
