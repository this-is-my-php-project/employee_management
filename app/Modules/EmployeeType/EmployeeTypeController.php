<?php

namespace App\Modules\EmployeeType;

use App\Http\Controllers\Controller;
use App\Modules\EmployeeType\EmployeeTypeService;
use App\Modules\EmployeeType\Resources\EmployeeTypeResource;
use App\Modules\EmployeeType\Requests\EmployeeTypeUserRequest;
use Illuminate\Http\Request;

class EmployeeTypeController extends Controller
{
    protected $employeeTypeService;

    public function __construct(EmployeeTypeService $employeeTypeService)
    {
        $this->middleware('auth');
        $this->employeeTypeService = $employeeTypeService;
    }

    public function getEmployeeTypes(EmployeeTypeUserRequest $request)
    {
        try {
            $employeeTypes = EmployeeType::whereHas('workspaces', function ($query) use ($request) {
                $query->where('workspace_id', $request->workspace_id);
            })->get();

            return $this->sendSuccess(
                'Employee Types retrieved successfully',
                EmployeeTypeResource::collection($employeeTypes)
            );
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\GET(
     *     path="/api/employee-types",
     *     tags={"Employee Types"},
     *     summary="Get Employee Types list",
     *     description="Get Employee Types List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(Request $request)
    {
        try {
            $this->authorize('viewAny', EmployeeType::class);

            $employeeTypes = $this->employeeTypeService->paginate($request->all());
            return EmployeeTypeResource::collection($employeeTypes);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\GET(
     *     path="/api/employee-types/{id}",
     *     tags={"Employee Types"},
     *     summary="Get Employee Type detail",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(Request $request, int $id)
    {
        try {
            $this->authorize('view', EmployeeType::class);

            $employeeType = $this->employeeTypeService->getOneOrFail($id, $request->all());
            return new EmployeeTypeResource($employeeType);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    // /**
    //  * @OA\POST(
    //  *     path="/api/employee-types",
    //  *     tags={"Employee Types"},
    //  *     summary="Create a new Employee Type",
    //  *     @OA\Response(response=400, description="Bad request"),
    //  *     @OA\Response(response=422, description="Unprocessable Entity"),
    //  * )
    //  */
    // public function store(EmployeeTypeStoreRequest $request)
    // {
    //     try {
    //         $this->authorize('create', EmployeeType::class);

    //         $payload = $request->validated();
    //         $employeeType = $this->employeeTypeService->createOne($payload);

    //         return new EmployeeTypeResource($employeeType);
    //     } catch (\Exception $e) {
    //         return $this->sendError($e->getMessage());
    //     }
    // }

    // /**
    //  * @OA\PUT(
    //  *     path="/api/employee-types/{id}",
    //  *     tags={"Employee Types"},
    //  *     summary="Update an existing Employee Type",
    //  *     @OA\Response(response=400, description="Bad request"),
    //  *     @OA\Response(response=422, description="Unprocessable Entity"),
    //  * )
    //  */
    // public function update(EmployeeTypeUpdateRequest $request, int $id)
    // {
    //     try {
    //         $this->authorize('update', EmployeeType::class);

    //         $payload = $request->validated();
    //         $employeeType = $this->employeeTypeService->updateOne($id, $payload);

    //         return new EmployeeTypeResource($employeeType);
    //     } catch (\Exception $e) {
    //         return $this->sendError($e->getMessage());
    //     }
    // }

    // /**
    //  * @OA\DELETE(
    //  *     path="/api/employee-types/{id}",
    //  *     tags={"Employee Types"},
    //  *     summary="Delete a Employee Type",
    //  *     @OA\Response(response=400, description="Bad request"),
    //  *     @OA\Response(response=404, description="Resource Not Found"),
    //  * )
    //  */
    // public function destroy(int $id)
    // {
    //     try {
    //         $this->authorize('delete', EmployeeType::class);

    //         $employeeType = $this->employeeTypeService->deleteOne($id);
    //         return new EmployeeTypeResource($employeeType);
    //     } catch (\Exception $e) {
    //         return $this->sendError($e->getMessage());
    //     }
    // }

    // /**
    //  * @OA\POST(
    //  *     path="/api/employee-types/{id}/restore",
    //  *     tags={"Employee Types"},
    //  *     summary="Restore a Employee Type from trash",
    //  *     @OA\Response(response=400, description="Bad request"),
    //  *     @OA\Response(response=404, description="Resource Not Found"),
    //  * )
    //  */
    // public function restore(int $id)
    // {
    //     try {
    //         $this->authorize('restore', EmployeeType::class);

    //         $employeeType = $this->employeeTypeService->restoreOne($id);
    //         return new EmployeeTypeResource($employeeType);
    //     } catch (\Exception $e) {
    //         return $this->sendError($e->getMessage());
    //     }
    // }
}
