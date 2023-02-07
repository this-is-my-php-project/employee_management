<?php

namespace App\Modules\Role;

use Illuminate\Support\Str;
use App\Libraries\Crud\BaseService;
use App\Modules\Role\RoleRepository;
use App\Modules\Workspace\Workspace;
use Illuminate\Database\Eloquent\Model;

class RoleService extends BaseService
{
    /**
     * @var array
     */
    protected array $allowedRelations = [
        'jobDetails'
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

    protected $roleRepo;

    /**
     * constructor.
     */
    public function __construct(RoleRepository $repo)
    {
        parent::__construct($repo);
        $this->roleRepo = $repo;
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

    public function deleteOne(string|int $id): ?Role
    {
        $role = $this->repo->getOneOrFail($id, []);

        if ($role->level === 0) {
            throw new \Exception('Cannot delete root role');
        }

        if ($role->is_default === true) {
            throw new \Exception('Cannot delete default role');
        }
        if ($role->jobDetails()->count() > 0) {
            throw new \Exception('Cannot delete role with user');
        }

        $role->delete();
        return $role;
    }

    public function getRoleIds(): array
    {
        return $this->roleRepo->getRoleIds();
    }

    public function getDefaultRoleIds(): int
    {
        return $this->roleRepo->getDefaultRoleIds();
    }

    /**
     * Detach all roles from a workspace.
     * 
     * @param Workspace $workspace
     * @return Workspace
     */
    public function removeRolesFromWorkspace(Workspace $workspace): Workspace
    {
        $workspace->roles()->detach($this->getRoleIds());
        return $workspace;
    }
}
