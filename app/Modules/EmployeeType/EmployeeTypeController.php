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
            $employeeType = $this->employeeTypeService->getOneOrFail($id, $request->all());
            return new EmployeeTypeResource($employeeType);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
