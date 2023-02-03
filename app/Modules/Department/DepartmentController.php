<?php

namespace App\Modules\Department;

use App\Http\Controllers\Controller;
use App\Modules\Department\DepartmentService;
use App\Modules\Department\Resources\DepartmentResource;
use App\Modules\Department\Requests\DepartmentStoreRequest;
use App\Modules\Department\Requests\DepartmentUpdateRequest;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    protected $departmentService;

    public function __construct(DepartmentService $departmentService)
    {
        $this->middleware('auth');
        $this->departmentService = $departmentService;
    }

    /**
     * @OA\GET(
     *     path="/api/departments",
     *     tags={"Departments"},
     *     summary="Get Departments list",
     *     description="Get Departments List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(Request $request)
    {
        try {
            $this->authorize('viewAny', Department::class);

            $departments = $this->departmentService->paginate($request->all());
            return DepartmentResource::collection($departments);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\GET(
     *     path="/api/departments/{id}",
     *     tags={"Departments"},
     *     summary="Get Department detail",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(Request $request, int $id)
    {
        try {
            $this->authorize('view', Department::class);

            $department = $this->departmentService->getOneOrFail($id, $request->all());
            return new DepartmentResource($department);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\POST(
     *     path="/api/departments",
     *     tags={"Departments"},
     *     summary="Create a new Department",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function store(DepartmentStoreRequest $request)
    {
        try {
            $this->authorize('create', Department::class);

            $payload = $request->validated();
            $department = $this->departmentService->createOne($payload);

            return new DepartmentResource($department);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\PUT(
     *     path="/api/departments/{id}",
     *     tags={"Departments"},
     *     summary="Update an existing Department",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function update(DepartmentUpdateRequest $request, int $id)
    {
        try {
            $this->authorize('update', Department::class);

            $payload = $request->validated();
            $department = $this->departmentService->updateOne($id, $payload);

            return new DepartmentResource($department);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\DELETE(
     *     path="/api/departments/{id}",
     *     tags={"Departments"},
     *     summary="Delete a Department",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy(int $id)
    {
        try {
            $this->authorize('delete', Department::class);

            $department = $this->departmentService->deleteOne($id);
            return new DepartmentResource($department);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\POST(
     *     path="/api/departments/{id}/restore",
     *     tags={"Departments"},
     *     summary="Restore a Department from trash",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function restore(int $id)
    {
        try {
            $this->authorize('restore', Department::class);

            $department = $this->departmentService->restoreOne($id);
            return new DepartmentResource($department);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
