<?php

namespace App\Modules\Department;

use App\Http\Controllers\Controller;
use App\Modules\Department\DepartmentService;
use App\Modules\Department\Resources\DepartmentResource;
use App\Modules\Department\Requests\DepartmentStoreRequest;
use App\Modules\Department\Requests\DepartmentUpdateRequest;
use App\Modules\Department\Requests\DepartmentUserRequest;
use App\Modules\Department\Requests\MoveUserRequest;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    protected $departmentService;

    public function __construct(DepartmentService $departmentService)
    {
        $this->middleware('auth');
        $this->departmentService = $departmentService;
    }

    public function getDepartments(DepartmentUserRequest $request)
    {
        try {
            $departments = Department::where(
                'workspace_id',
                $request->workspace_id
            )->get();

            return $this->sendSuccess(
                'Departments retrieved successfully',
                DepartmentResource::collection($departments)
            );
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
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
            $payload = $request->validated();

            $this->authorize('create', [Department::class, $payload['workspace_id']]);

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
            $payload = $request->validated();

            $this->authorize('update', [Department::class, $payload['workspace_id']]);

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
    public function destroy(Request $request, int $id)
    {
        try {
            $request->validate([
                'workspace_id' => 'required',
            ]);

            $this->authorize('delete', [Department::class, $request->workspace_id]);

            $department = $this->departmentService->deleteOne($id);

            return new DepartmentResource($department);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function moveUser(MoveUserRequest $request)
    {
        try {
            $payload = $request->validated();

            $this->authorize('update', Department::class, $payload['workspace_id']);

            $department = $this->departmentService->moveUser($payload);
            if (empty($department)) {
                return $this->sendError('Something went wrong');
            }

            return response()->json([
                'message' => 'User moved successfully',
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
