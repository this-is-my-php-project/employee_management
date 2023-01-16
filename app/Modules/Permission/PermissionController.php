<?php

namespace App\Modules\Permission;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Permission\Permission;
use App\Modules\Permission\PermissionService;
use App\Modules\Permission\Resources\PermissionResource;
use App\Modules\Permission\Requests\PermissionIndexRequest;
use App\Modules\Permission\Requests\PermissionStoreRequest;
use App\Modules\Permission\Requests\PermissionUpdateRequest;

class PermissionController extends Controller
{
    protected $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->middleware('auth');
        $this->permissionService = $permissionService;
    }

    /**
     * @OA\GET(
     *     path="/api/permissions",
     *     tags={"Permissions"},
     *     summary="Get Permissions list",
     *     description="Get Permissions List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(Request $request)
    {
        try {
            $this->authorize('viewAny', Permission::class);

            $payload = $request->all();
            $permissions = $this->permissionService->paginate($payload);

            return PermissionResource::collection($permissions);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\GET(
     *     path="/api/permissions/{id}",
     *     tags={"Permissions"},
     *     summary="Get Permission detail",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(PermissionIndexRequest $request, int $id)
    {
        try {
            $this->authorize('view', Permission::class);

            $payload = $request->validated();
            $permission = $this->permissionService->getOneOrFail($id, $payload);

            return new PermissionResource($permission);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\POST(
     *     path="/api/permissions",
     *     tags={"Permissions"},
     *     summary="Create a new Permission",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function store(PermissionStoreRequest $request)
    {
        try {
            $this->authorize('create', Permission::class);

            $payload = $request->validated();
            $permission = $this->permissionService->createOne($payload);

            return new PermissionResource($permission);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\PUT(
     *     path="/api/permissions/{id}",
     *     tags={"Permissions"},
     *     summary="Update an existing Permission",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function update(PermissionUpdateRequest $request, int $id)
    {
        try {
            $this->authorize('update', Permission::class);

            $payload = $request->validated();
            $permission = $this->permissionService->updateOne($id, $payload);

            return new PermissionResource($permission);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\DELETE(
     *     path="/api/permissions/{id}",
     *     tags={"Permissions"},
     *     summary="Delete a Permission",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy(int $id)
    {
        try {
            $this->authorize('delete', Permission::class);

            $permission = $this->permissionService->deleteOne($id);
            return new PermissionResource($permission);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\POST(
     *     path="/api/permissions/{id}/restore",
     *     tags={"Permissions"},
     *     summary="Restore a Permission from trash",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function restore(int $id)
    {
        try {
            $this->authorize('restore', Permission::class);

            $permission = $this->permissionService->restoreOne($id);
            return new PermissionResource($permission);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
