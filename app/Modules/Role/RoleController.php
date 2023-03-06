<?php

namespace App\Modules\Role;

use App\Modules\Role\Role;
use App\Modules\Role\RoleService;
use App\Http\Controllers\Controller;
use App\Modules\Role\Requests\RoleUserRequest;
use App\Modules\Role\Resources\RoleResource;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->middleware('auth');
        $this->roleService = $roleService;
    }

    /**
     * @OA\GET(
     *     path="/api/roles",
     *     tags={"Roles"},
     *     summary="Get Roles list",
     *     description="Get Roles List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(Request $request)
    {
        try {
            $roles = $this->roleService->paginate($request->all());
            return RoleResource::collection($roles);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\GET(
     *     path="/api/roles/{id}",
     *     tags={"Roles"},
     *     summary="Get Role detail",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(Request $request, int $id)
    {
        try {
            $role = $this->roleService->getOneOrFail($id, $request->all());
            return new RoleResource($role);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
