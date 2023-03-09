<?php

namespace App\Modules\Profile;

use App\Libraries\Crud\BaseService;
use App\Modules\Adjustment\AdjustmentService;
use App\Modules\AttendanceRecord\AttendanceRecordService;
use App\Modules\JobDetail\JobDetailService;
use Illuminate\Support\Facades\DB;

class ProfileService extends BaseService
{
    protected array $allowedRelations = [
        'user',
        'workspace',
        'jobDetail',
        'jobDetail.role',
        'jobDetail.department',
        'jobDetail.workspace',
    ];

    protected JobDetailService $jobDetailService;
    protected ProfileRepository $profileRepo;
    protected AttendanceRecordService $attendanceRecordService;
    protected AdjustmentService $adjustmentService;

    public function __construct(
        ProfileRepository $repo,
        JobDetailService $jobDetailService,
        AttendanceRecordService $attendanceRecordService,
        AdjustmentService $adjustmentService
    ) {
        parent::__construct($repo);
        $this->profileRepo = $repo;
        $this->jobDetailService = $jobDetailService;
        $this->attendanceRecordService = $attendanceRecordService;
        $this->adjustmentService = $adjustmentService;
    }

    /**
     * Create default profile for user
     *
     * @param array $user
     * @param int $workspaceId
     * @return Profile
     */
    public function createDefault(array $user, int $workspaceId): Profile
    {
        return $this->repo->createOne([
            'name' => $user['name'],
            'alias' => '',
            'avatar' => $user['avatar'] ?? null,
            'phone' => $user['phone'] ?? null,
            'email' => $user['email'] ?? null,
            'user_id' => $user['id'],
            'workspace_id' => $workspaceId,
        ]);
    }

    public function deleteOne(string|int $id): ?Profile
    {
        return DB::transaction(function () use ($id) {
            $profile = $this->getOneOrFail($id);

            $jobDetailId = $profile->jobDetail->id;

            $profile = $this->repo->deleteOne($profile);

            // Delete job detail
            $this->jobDetailService->deleteOne($jobDetailId);

            // Delete attendance record
            $this->attendanceRecordService->deleteMultipleByField('profile_id', $id);

            // Delete adjustment
            $this->adjustmentService->deleteMultipleByField('profile_id', $id);

            return $profile;
        });
    }

    public function deleteAllFromWorkspace(string|int $workspaceId): bool
    {
        return $this->profileRepo
            ->deleteAllFromWorkspace($workspaceId);
    }

    public function getOneByWorkspace(
        string|int $userId,
        string|int $workspaceId
    ): ?Profile {
        return $this->profileRepo->getOneByWorkspace($userId, $workspaceId);
    }

    public function disableProfile(string|int $id): ?Profile
    {
        $model = $this->getOneOrFail($id);
        return $this->repo->updateOne($model, [
            'is_active' => false,
        ]);
    }

    public function getInfo(string|int $workspaceId): ?Profile
    {
        return Profile::where('workspace_id', $workspaceId)
            ->where('user_id', auth()->id())
            ->first();
    }

    public function getSingleProfile(string|int $workspaceId): ?Profile
    {
        return Profile::where('workspace_id', $workspaceId)
            ->where('user_id', auth()->id())
            ->first();
    }
}
