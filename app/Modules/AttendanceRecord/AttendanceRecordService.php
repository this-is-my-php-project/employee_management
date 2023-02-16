<?php

namespace App\Modules\AttendanceRecord;

use App\Libraries\Crud\BaseService;

class AttendanceRecordService extends BaseService
{
    protected array $allowedRelations = [];

    public function __construct(AttendanceRecordRepository $repo)
    {
        parent::__construct($repo);
    }

    public function createOne(array $payload): ?AttendanceRecord
    {
        return parent::createOne($payload);
    }
}
