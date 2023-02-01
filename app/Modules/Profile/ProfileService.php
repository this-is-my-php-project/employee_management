<?php

namespace App\Modules\Profile;

use App\Libraries\Crud\BaseService;

class ProfileService extends BaseService
{
    protected array $allowedRelations = [];

    public function __construct(ProfileRepository $repo)
    {
        parent::__construct($repo);
    }
}
