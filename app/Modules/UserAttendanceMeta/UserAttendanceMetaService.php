<?php

namespace App\Modules\UserAttendanceMeta;

use App\Libraries\Crud\BaseService;

class UserAttendanceMetaService extends BaseService
{
    protected array $allowedRelations = [
        'workspace',
        'jobDetail',
        'jobDetail.profile'
    ];

    public function __construct(UserAttendanceMetaRepository $repo)
    {
        parent::__construct($repo);
    }

    /**
     * Create one UserAttendanceMeta
     * 
     * @param array $payload
     * @return UserAttendanceMeta|null
     */
    public function createOne(array $payload): ?UserAttendanceMeta
    {
        return $this->repo->createOne([
            'clock_in' => $payload['clock_in'],
            'clock_out' => $payload['clock_out'],
            'workspace_id' => $payload['workspace_id'],
            'job_detail_id' => $payload['job_detail_id'],
        ]);
    }

    /**
     * Create one UserAttendanceMeta
     * 
     * @param array $payload
     * @return bool
     */
    public function insertMany(array $payload): bool
    {
        $newPayload = [];
        foreach ($payload['job_detail_id'] as $key => $value) {
            $payload = [
                'clock_in' => $payload['clock_in'],
                'clock_out' => $payload['clock_out'],
                'workspace_id' => $payload['workspace_id'],
                'job_detail_id' => $value,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $newPayload[] = $payload;
        }

        return $this->repo->insertMany($newPayload);
    }
}
