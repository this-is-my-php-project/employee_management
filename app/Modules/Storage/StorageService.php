<?php

namespace App\Modules\Storage;

use App\Libraries\Crud\BaseService;

class StorageService extends BaseService
{
    protected array $allowedRelations = [];

    public function __construct(StorageRepository $repo)
    {
        parent::__construct($repo);
    }
}
