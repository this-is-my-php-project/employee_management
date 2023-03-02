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

    public function getRoles(RoleUserRequest $request)
    {
        try {
            $roles = Role::whereHas('workspaces', function ($query) use ($request) {
                $query->where('workspace_id', $request->workspace_id);
            })->get();

            return RoleResource::collection($roles);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
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
            $this->authorize('viewAny', Role::class);

            $filters = [
                'filters' => [
                    [
                        'field' => 'hidden',
                        'value' => '0',
                        'operator' => '='
                    ]
                ]
            ];
            $request->merge($filters);

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
            $this->authorize('view', Role::class);

            $role = $this->roleService->getOneOrFail($id, $request->all());
            return new RoleResource($role);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    // /**
    //  * @OA\POST(
    //  *     path="/api/roles",
    //  *     tags={"Roles"},
    //  *     summary="Create a new Role",
    //  *     @OA\Response(response=400, description="Bad request"),
    //  *     @OA\Response(response=422, description="Unprocessable Entity"),
    //  * )
    //  */
    // public function store(RoleStoreRequest $request)
    // {
    //     try {
    //         $this->authorize('create', Role::class);

    //         $role = $this->roleService->createOne($request->all());
    //         return new RoleResource($role);
    //     } catch (\Exception $e) {
    //         return $this->sendError($e->getMessage());
    //     }
    // }

    // /**
    //  * @OA\PUT(
    //  *     path="/api/roles/{id}",
    //  *     tags={"Roles"},
    //  *     summary="Update an existing Role",
    //  *     @OA\Response(response=400, description="Bad request"),
    //  *     @OA\Response(response=422, description="Unprocessable Entity"),
    //  * )
    //  */
    // public function update(RoleUpdateRequest $request, int $id)
    // {
    //     try {
    //         $this->authorize('update', Role::class);

    //         $role = $this->roleService->updateOne($id, $request->all());
    //         return new RoleResource($role);
    //     } catch (\Exception $e) {
    //         return $this->sendError($e->getMessage());
    //     }
    // }

    // /**
    //  * @OA\DELETE(
    //  *     path="/api/roles/{id}",
    //  *     tags={"Roles"},
    //  *     summary="Delete a Role",
    //  *     @OA\Response(response=400, description="Bad request"),
    //  *     @OA\Response(response=404, description="Resource Not Found"),
    //  * )
    //  */
    // public function destroy(int $id)
    // {
    //     try {
    //         $this->authorize('delete', Role::class);

    //         $role = $this->roleService->deleteOne($id);
    //         return new RoleResource($role);
    //     } catch (\Exception $e) {
    //         return $this->sendError($e->getMessage());
    //     }
    // }

    // /**
    //  * @OA\POST(
    //  *     path="/api/roles/{id}/restore",
    //  *     tags={"Roles"},
    //  *     summary="Restore a Role from trash",
    //  *     @OA\Response(response=400, description="Bad request"),
    //  *     @OA\Response(response=404, description="Resource Not Found"),
    //  * )
    //  */
    // public function restore(int $id)
    // {
    //     try {
    //         $this->authorize('restore', Role::class);

    //         $role = $this->roleService->restoreOne($id);
    //         return new RoleResource($role);
    //     } catch (\Exception $e) {
    //         return $this->sendError($e->getMessage());
    //     }
    // }
}
