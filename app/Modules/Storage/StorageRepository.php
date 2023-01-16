<?php

namespace App\Modules\Storage;

use App\Libraries\Crud\BaseRepository;
use App\Modules\Storage\Storage;

class StorageRepository extends BaseRepository
{
    public function __construct(Storage $storage)
    {
        parent::__construct($storage);
    }
}
