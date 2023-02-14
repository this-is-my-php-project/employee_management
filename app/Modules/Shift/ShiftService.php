<?php

namespace App\Modules\Shift;

use App\Libraries\Crud\BaseService;
use App\Modules\JobDetail\JobDetail;

class ShiftService extends BaseService
{
    protected array $allowedRelations = [];

    public function __construct(ShiftRepository $repo)
    {
        parent::__construct($repo);
    }

    public function assignShift(array $payload)
    {
        $shift = $this->repo->getOneOrFail($payload['shift_id']);
        JobDetail::whereIn('id', $payload['job_detail_ids'])->update(['shift_id' => $shift->id]);

        return $shift;
    }
}
