<?php

namespace App\Modules\AttendanceService;

use App\Http\Controllers\Controller;
use App\Modules\AttendanceService\AttendanceServiceService;
use App\Modules\AttendanceService\Requests\AttendanceServiceAddWorkspaceRequest;
use App\Modules\AttendanceService\Resources\AttendanceServiceResource;
use App\Modules\AttendanceService\Requests\AttendanceServiceStoreRequest;
use App\Modules\AttendanceService\Requests\AttendanceServiceUpdateRequest;
use Illuminate\Http\Request;

class AttendanceServiceController extends Controller
{
    protected $attendanceServiceService;

    public function __construct(AttendanceServiceService $attendanceServiceService)
    {
        $this->middleware('auth');
        $this->attendanceServiceService = $attendanceServiceService;
    }

    /**
     * @OA\GET(
     *     path="/api/attendance-services",
     *     tags={"Attendance Services"},
     *     summary="Get Attendance Services list",
     *     description="Get Attendance Services List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(Request $request)
    {
        try {
            $this->authorize('viewAny', AttendanceService::class);

            $attendanceServices = $this->attendanceServiceService->paginate($request->all());
            return AttendanceServiceResource::collection($attendanceServices);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\GET(
     *     path="/api/attendance-services/{id}",
     *     tags={"Attendance Services"},
     *     summary="Get Attendance Service detail",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(Request $request, int $id)
    {
        try {
            $this->authorize('view', AttendanceService::class);

            $attendanceService = $this->attendanceServiceService->getOneOrFail($id, $request->all());
            return new AttendanceServiceResource($attendanceService);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function joinAttendanceService(AttendanceServiceAddWorkspaceRequest $request)
    {
        try {
            // $this->authorize('view', AttendanceService::class);

            $payload = $request->validated();
            $attendanceService = $this->attendanceServiceService->joinAttendanceService($payload);
            return new AttendanceServiceResource($attendanceService);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    // /**
    //  * @OA\POST(
    //  *     path="/api/attendance-services",
    //  *     tags={"Attendance Services"},
    //  *     summary="Create a new Attendance Service",
    //  *     @OA\Response(response=400, description="Bad request"),
    //  *     @OA\Response(response=422, description="Unprocessable Entity"),
    //  * )
    //  */
    // public function store(AttendanceServiceStoreRequest $request)
    // {
    //     try {
    //         $this->authorize('create', AttendanceService::class);

    //         $payload = $request->validated();
    //         $attendanceService = $this->attendanceServiceService->createOne($payload);

    //         return new AttendanceServiceResource($attendanceService);
    //     } catch (\Exception $e) {
    //         return $this->sendError($e->getMessage());
    //     }
    // }

    // /**
    //  * @OA\PUT(
    //  *     path="/api/attendance-services/{id}",
    //  *     tags={"Attendance Services"},
    //  *     summary="Update an existing Attendance Service",
    //  *     @OA\Response(response=400, description="Bad request"),
    //  *     @OA\Response(response=422, description="Unprocessable Entity"),
    //  * )
    //  */
    // public function update(AttendanceServiceUpdateRequest $request, int $id)
    // {
    //     try {
    //         $this->authorize('update', AttendanceService::class);

    //         $payload = $request->validated();
    //         $attendanceService = $this->attendanceServiceService->updateOne($id, $payload);

    //         return new AttendanceServiceResource($attendanceService);
    //     } catch (\Exception $e) {
    //         return $this->sendError($e->getMessage());
    //     }
    // }

    // /**
    //  * @OA\DELETE(
    //  *     path="/api/attendance-services/{id}",
    //  *     tags={"Attendance Services"},
    //  *     summary="Delete a Attendance Service",
    //  *     @OA\Response(response=400, description="Bad request"),
    //  *     @OA\Response(response=404, description="Resource Not Found"),
    //  * )
    //  */
    // public function destroy(int $id)
    // {
    //     try {
    //         $this->authorize('delete', AttendanceService::class);

    //         $attendanceService = $this->attendanceServiceService->deleteOne($id);
    //         return new AttendanceServiceResource($attendanceService);
    //     } catch (\Exception $e) {
    //         return $this->sendError($e->getMessage());
    //     }
    // }

    // /**
    //  * @OA\POST(
    //  *     path="/api/attendance-services/{id}/restore",
    //  *     tags={"Attendance Services"},
    //  *     summary="Restore a Attendance Service from trash",
    //  *     @OA\Response(response=400, description="Bad request"),
    //  *     @OA\Response(response=404, description="Resource Not Found"),
    //  * )
    //  */
    // public function restore(int $id)
    // {
    //     try {
    //         $this->authorize('restore', AttendanceService::class);

    //         $attendanceService = $this->attendanceServiceService->restoreOne($id);
    //         return new AttendanceServiceResource($attendanceService);
    //     } catch (\Exception $e) {
    //         return $this->sendError($e->getMessage());
    //     }
    // }
}
