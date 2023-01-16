<?php

namespace App\Modules\Auth;

use App\Libraries\Crud\BaseRepository;
use App\Modules\Auth\Auth;

class AuthRepository extends BaseRepository
{
    public function __construct(Auth $auth)
    {
        parent::__construct($auth);
    }
}
