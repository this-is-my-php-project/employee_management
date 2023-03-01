<?php

namespace App\Modules\Service/AttendanceRecordService;

use App\Http\Controllers\Controller;
use App\Modules\Service/AttendanceRecordService\Service/AttendanceRecordServiceService;
use App\Modules\Service/AttendanceRecordService\Resources\Service/AttendanceRecordServiceResource;
use App\Modules\Service/AttendanceRecordService\Requests\Service/AttendanceRecordServiceStoreRequest;
use App\Modules\Service/AttendanceRecordService\Requests\Service/AttendanceRecordServiceUpdateRequest;
use Illuminate\Http\Request;

class Service/AttendanceRecordServiceController extends Controller
{
    protected $service/AttendanceRecordServiceService;

    public function __construct(Service/AttendanceRecordServiceService $service/AttendanceRecordServiceService)
    {
        $this->middleware('auth');
        $this->service/AttendanceRecordServiceService = $service/AttendanceRecordServiceService;
    }

    /**
     * @OA\GET(
     *     path="/api/service-attendance-record-services",
     *     tags={"Service/ Attendance Record Services"},
     *     summary="Get Service/ Attendance Record Services list",
     *     description="Get Service/ Attendance Record Services List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(Request $request)
    {
        try {
            $this->authorize('viewAny', Service/AttendanceRecordService::class);
            
            $service/AttendanceRecordServices = $this->service/AttendanceRecordServiceService->paginate($request->all());
            return Service/AttendanceRecordServiceResource::collection($service/AttendanceRecordServices);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\GET(
     *     path="/api/service-attendance-record-services/{id}",
     *     tags={"Service/ Attendance Record Services"},
     *     summary="Get Service/ Attendance Record Service detail",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(Request $request, int $id)
    {
        try {
            $this->authorize('view', Service/AttendanceRecordService::class);

            $service/AttendanceRecordService = $this->service/AttendanceRecordServiceService->getOneOrFail($id, $request->all());
            return new Service/AttendanceRecordServiceResource($service/AttendanceRecordService);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\POST(
     *     path="/api/service-attendance-record-services",
     *     tags={"Service/ Attendance Record Services"},
     *     summary="Create a new Service/ Attendance Record Service",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function store(Service/AttendanceRecordServiceStoreRequest $request)
    {
        try {
            $this->authorize('create', Service/AttendanceRecordService::class);

            $payload = $request->validated();
            $service/AttendanceRecordService = $this->service/AttendanceRecordServiceService->createOne($payload);

            return new Service/AttendanceRecordServiceResource($service/AttendanceRecordService);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\PUT(
     *     path="/api/service-attendance-record-services/{id}",
     *     tags={"Service/ Attendance Record Services"},
     *     summary="Update an existing Service/ Attendance Record Service",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function update(Service/AttendanceRecordServiceUpdateRequest $request, int $id)
    {
        try {
            $this->authorize('update', Service/AttendanceRecordService::class);

            $payload = $request->validated();
            $service/AttendanceRecordService = $this->service/AttendanceRecordServiceService->updateOne($id, $payload);

            return new Service/AttendanceRecordServiceResource($service/AttendanceRecordService);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\DELETE(
     *     path="/api/service-attendance-record-services/{id}",
     *     tags={"Service/ Attendance Record Services"},
     *     summary="Delete a Service/ Attendance Record Service",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy(int $id)
    {
        try {
            $this->authorize('delete', Service/AttendanceRecordService::class);

            $service/AttendanceRecordService = $this->service/AttendanceRecordServiceService->deleteOne($id);
            return new Service/AttendanceRecordServiceResource($service/AttendanceRecordService);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\POST(
     *     path="/api/service-attendance-record-services/{id}/restore",
     *     tags={"Service/ Attendance Record Services"},
     *     summary="Restore a Service/ Attendance Record Service from trash",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function restore(int $id)
    {
        try {
            $this->authorize('restore', Service/AttendanceRecordService::class);

            $service/AttendanceRecordService = $this->service/AttendanceRecordServiceService->restoreOne($id);
            return new Service/AttendanceRecordServiceResource($service/AttendanceRecordService);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
