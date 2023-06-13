<?php

namespace App\Modules\Adjustment;

use App\Libraries\Crud\BaseService;
use App\Modules\Profile\Profile;

class AdjustmentService extends BaseService
{
    protected array $allowedRelations = [];

    public function __construct(AdjustmentRepository $repo)
    {
        parent::__construct($repo);
    }

    public function createOne(array $payload): Adjustment
    {
        $adjustment = $this->repo->createOne([
            'clock_in' => $payload['clock_in'],
            'clock_out' => $payload['clock_out'],
            'start_date' => $payload['start_date'],
            'end_date' => $payload['end_date'],
            'adjustment_type' => $payload['adjustment_type'],
            'attendance_record_id' => $payload['attendance_record_id'],
            'workspace_id' => $payload['workspace_id'],
            'profile_id' => Profile::getProfile($payload['workspace_id'])->id,
        ]);
        return $adjustment;
    }
}
