<?php

namespace App\Modules\Role;

use Illuminate\Support\Str;
use App\Libraries\Crud\BaseService;
use App\Modules\Role\RoleRepository;

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
     * @var arrays
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

    /**
     * Create a new role.
     * 
     * @param array $payload
     * @return Role
     */
    public function createOne(array $payload): Role
    {
        $payload['name'] = Str::lower(trim($payload['name']));
        return $this->repo->createOne([
            'name' => $payload['name'],
            'key' => Str::slug($payload['name'], '_'),
            'description' => $payload['description'],
            'parent_id' => $payload['parent_id'],
            'level' => $payload['level'],
            'is_active' => $payload['is_active'] ?? true,
        ]);
    }
}
