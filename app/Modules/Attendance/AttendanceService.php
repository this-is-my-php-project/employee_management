<?php

namespace App\Modules\Attendance;

use App\Libraries\Crud\BaseService;

class AttendanceService extends BaseService
{
    protected array $allowedRelations = [];

    public function __construct(AttendanceRepository $repo)
    {
        parent::__construct($repo);
    }

    public function createOne(array $payload): Attendance
    {
        return $this->repo->createOne([
            'start_date' => $payload['start_date'],
            'end_date' => $payload['end_date'],
            'start_time' => $payload['start_time'],
            'end_time' => $payload['end_time'],
            'status' => $payload['status'] ?? true,
            'user_id' => auth()->id(),
            'workspace_id' => $payload['workspace_id'],
        ]);
    }
}
