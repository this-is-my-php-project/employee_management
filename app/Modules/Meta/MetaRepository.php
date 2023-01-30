<?php

namespace App\Modules\Meta;

use App\Libraries\Crud\BaseRepository;
use App\Modules\Meta\Meta;

class MetaRepository extends BaseRepository
{
    public function __construct(Meta $meta)
    {
        parent::__construct($meta);
    }
}
