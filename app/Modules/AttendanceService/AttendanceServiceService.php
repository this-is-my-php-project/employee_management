<?php

namespace App\Modules\AttendanceService;

use App\Libraries\Crud\BaseService;

class AttendanceServiceService extends BaseService
{
    protected array $allowedRelations = [
        'workspaces',
    ];

    public function __construct(AttendanceServiceRepository $repo)
    {
        parent::__construct($repo);
    }

    public function joinAttendanceService(array $payload): AttendanceService
    {
        $attendanceService = AttendanceService::getAttendanceService();
        $attendanceService->workspaces()->attach([
            $payload['workspace_id'] => ['joined_at' => now()]
        ]);

        return $attendanceService;
    }
}
