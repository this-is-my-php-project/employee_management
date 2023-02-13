<?php

namespace App\Modules\UserAttendanceMeta;

use App\Libraries\Crud\BaseRepository;
use App\Modules\UserAttendanceMeta\UserAttendanceMeta;

class UserAttendanceMetaRepository extends BaseRepository
{
    public function __construct(UserAttendanceMeta $userAttendanceMeta)
    {
        parent::__construct($userAttendanceMeta);
    }
}
