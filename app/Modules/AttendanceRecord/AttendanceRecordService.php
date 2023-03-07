<?php

namespace App\Modules\AttendanceRecord;

use App\Libraries\Crud\BaseService;
use App\Modules\Adjustment\Adjustment;
use App\Modules\Adjustment\AdjustmentRepository;
use App\Modules\Adjustment\AdjustmentService;
use App\Modules\Adjustment\Constants\AdjustmentConstant;
use App\Modules\Profile\ProfileService;
use App\Modules\User\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AttendanceRecordService extends BaseService
{
    protected array $allowedRelations = [];

    protected ProfileService $profileService;
    protected AdjustmentRepository $adjustmentRepo;
    protected AdjustmentService $adjustmentService;
    protected AttendanceRecordRepository $attendanceRecordRepo;

    public function __construct(
        AttendanceRecordRepository $repo,
        ProfileService $profileService,
        AdjustmentRepository $adjustmentRepo,
        AdjustmentService $adjustmentService,
        AttendanceRecordRepository $attendanceRecordRepo
    ) {
        parent::__construct($repo);
        $this->profileService = $profileService;
        $this->adjustmentRepo = $adjustmentRepo;
        $this->adjustmentService = $adjustmentService;
        $this->attendanceRecordRepo = $attendanceRecordRepo;
    }

    public function createOne(array $payload): AttendanceRecord
    {
        try {
            DB::beginTransaction();
            $clockIn = $payload['clock_in'];
            $clockOut = $payload['clock_out'];
            $date = Carbon::now()->format('Y-m-d');
            $workspaceId = $payload['workspace_id'];

            $profile = $this->profileService->getSingleProfile($workspaceId);
            $shift = $profile->jobDetail->shift;

            if (empty($shift)) {
                throw new \Exception('You have no shift assigned');
            }

            $todayRecords = $this->attendanceRecordRepo->getTodayRecords(
                $profile->id,
                $workspaceId,
                $shift->id
            );

            if (!empty($todayRecords)) {
                throw new \Exception('You have already clocked in');
            }

            $attendanceRecord = $this->repo->createOne([
                'clock_in' => $clockIn,
                'clock_out' => $clockOut,
                'start_date' => $date,
                'end_date' => $date,
                'profile_id' => $profile->id,
                'shift_id' => $shift->id,
                'workspace_id' => $workspaceId,
            ]);

            if ($clockIn > $shift->clock_in) {
                $this->createAdjustment([
                    'clock_in' => $clockIn,
                    'clock_out' => $clockOut,
                    'start_date' => $date,
                    'end_date' => $date,
                    'adjustment_type' => AdjustmentConstant::LATE,
                    'attendance_record_id' => $attendanceRecord->id,
                    'workspace_id' => $workspaceId,
                    'profile_id' => $profile->id,
                ]);
            }

            if ($clockOut < $shift->clock_out) {
                $this->adjustmentService->createOne([
                    'clock_in' => $clockIn,
                    'clock_out' => $clockOut,
                    'start_date' => $date,
                    'end_date' => $date,
                    'adjustment_type' => AdjustmentConstant::LEAVE_EARLY,
                    'attendance_record_id' => $attendanceRecord->id,
                    'workspace_id' => $workspaceId,
                    'profile_id' => $profile->id,
                ]);
            }

            DB::commit();

            return $attendanceRecord;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function createAdjustment(array $payload): Adjustment
    {
        return $this->adjustmentRepo->createOne([
            'clock_in' => $payload['clock_in'],
            'clock_out' => $payload['clock_out'],
            'start_date' => $payload['start_date'],
            'end_date' => $payload['end_date'],
            'adjustment_type' => $payload['adjustment_type'],
            'attendance_record_id' => $payload['attendance_record_id'],
            'workspace_id' => $payload['workspace_id'],
            'profile_id' => $payload['profile_id'],
        ]);
    }

    public function getAttendanceRecords(int $workspaceId, int $profileId)
    {
        $attendanceRecords = $this->attendanceRecordRepo->getAttendanceRecords($workspaceId, $profileId);

        $totalLate = 0;
        $totalLeaveEarly = 0;
        $attended = 0;
        $absent = 0;

        foreach ($attendanceRecords as $attendanceRecord) {
            $adjusts = $attendanceRecord->adjustments;

            foreach ($adjusts as $adjust) {
                if (!empty($adjust)) {

                    if ($adjust->adjustment_type === AdjustmentConstant::LATE) {
                        $totalLate++;
                    }
                    if ($adjust->adjustment_type === AdjustmentConstant::LEAVE_EARLY) {
                        $totalLeaveEarly++;
                    }
                    if ($adjust->adjustment_type === AdjustmentConstant::ABSENT) {
                        $absent++;
                    }
                }
            }

            $attended++;
        }

        return [
            'meta' => [
                'total_late' => $totalLate,
                'total_leave_early' => $totalLeaveEarly,
                'attended' => $attended,
                'absent' => $absent,
            ],
            'data' => $attendanceRecords,
        ];
    }

    public function getAttendanceRecordInfo(int $workspaceId)
    {
        $profileId = $this->profileService->getSingleProfile($workspaceId)->id;
        return $this->getAttendanceRecords($workspaceId, $profileId);
    }
}
