<?php

namespace App\Modules\AttendanceRecord;

use App\Libraries\Crud\BaseRepository;
use App\Modules\AttendanceRecord\AttendanceRecord;
use Carbon\Carbon;

class AttendanceRecordRepository extends BaseRepository
{
    public function __construct(AttendanceRecord $attendanceRecord)
    {
        parent::__construct($attendanceRecord);
    }

    public function getTodayRecords(int $profileId, int $workspaceId, int $shiftId)
    {
        $date = Carbon::now()->format('Y-m-d');

        return $this->model->where('profile_id', $profileId)
            ->where('workspace_id', $workspaceId)
            ->where('start_date', $date)
            ->where('end_date', $date)
            ->where('shift_id', $shiftId)
            ->get();
    }
}
