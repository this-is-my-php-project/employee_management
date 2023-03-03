<?php

namespace App\Modules\Shift;

use App\Libraries\Crud\BaseService;
use App\Modules\JobDetail\JobDetailRepository;

class ShiftService extends BaseService
{
    protected array $allowedRelations = [];

    protected JobDetailRepository $jobDetailRepo;

    public function __construct(
        ShiftRepository $repo,
        JobDetailRepository $jobDetailRepo
    ) {
        parent::__construct($repo);
        $this->jobDetailRepo = $jobDetailRepo;
    }

    public function assignUser(array $payload): bool
    {
        $jobDetailIds = $payload['job_detail_ids'];
        $shiftId = $payload['shift_id'];

        $data = $this->jobDetailRepo->assignToShift($jobDetailIds, $shiftId);
        if (empty($data)) {
            abort(500, 'Something went wrong');
        }

        return $data;
    }
}
