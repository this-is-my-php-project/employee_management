<?php

namespace App\Modules\Department;

use App\Libraries\Crud\BaseRepository;
use App\Modules\Department\Department;
use Illuminate\Database\Eloquent\Collection;

class DepartmentRepository extends BaseRepository
{
    public function __construct(Department $department)
    {
        parent::__construct($department);
    }

    /**
     * @param int $workspaceId
     * @return array
     */
    public function getAllDepartmentWorkspace(int $workspaceId): Collection
    {
        return $this->model->where('workspace_id', '=', $workspaceId)->get();
    }

    /**
     * @param int $workspaceId
     * @return bool
     */
    public function deleteAllFromWorkspace(int $workspaceId): bool
    {
        return $this->model->where('workspace_id', '=', $workspaceId)->delete();
    }

    /**
     * Move user from one department to another
     * 
     * @param string|int $fromDepartmentId
     * @param string|int $toDepartmentId
     * @param array $profileIds
     * @return bool
     */
    public function moveUser(string|int $fromDepartmentId, string|int $toDepartmentId, array $profileIds): bool
    {
        return $this->model->where('id', '=', $fromDepartmentId)
            ->first()
            ->jobDetails()
            ->whereIn('profile_id', $profileIds)
            ->update(['department_id' => $toDepartmentId]);
    }
}
