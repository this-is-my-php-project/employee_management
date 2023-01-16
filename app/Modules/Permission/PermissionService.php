<?php

namespace App\Modules\Permission;

use Illuminate\Support\Str;
use App\Libraries\Crud\BaseService;
use App\Modules\Permission\PermissionRepository;

class PermissionService extends BaseService
{
    /**
     * @var array
     */
    protected array $allowedRelations = [
        'roles'
    ];

    /**
     * @var array
     */
    protected array $filterable = [
        'name',
        'title',
        'description',
        'status',
        'created_at',
        'updated_at'
    ];

    /**
     * constructor.
     */
    public function __construct(PermissionRepository $repo)
    {
        parent::__construct($repo);
    }

    public static function getTitle($data): string
    {
        $title = explode('_', $data);
        $title = Str::title(implode(' ', $title));
        $title = Str::ucfirst($title);

        return $title;
    }

    public static function getLowerCase($data): string
    {
        $lower = explode('_', $data);
        $lower = Str::lower(implode(' ', $lower));
        $lower = Str::lower($lower);

        return $lower;
    }
}
