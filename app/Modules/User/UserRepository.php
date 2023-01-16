<?php

namespace App\Modules\User;

use App\Libraries\Crud\BaseRepository;
use App\Modules\User\User;

class UserRepository extends BaseRepository
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }
}
