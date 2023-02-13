<?php

namespace App\Modules\AttendanceRecord;

use App\Http\Controllers\Controller;
use App\Modules\AttendanceRecord\AttendanceRecordService;
use App\Modules\AttendanceRecord\Resources\AttendanceRecordResource;
use App\Modules\AttendanceRecord\Requests\AttendanceRecordStoreRequest;
use App\Modules\AttendanceRecord\Requests\AttendanceRecordUpdateRequest;
use Illuminate\Http\Request;

class AttendanceRecordController extends Controller
{
    protected $attendanceRecordService;

    public function __construct(AttendanceRecordService $attendanceRecordService)
    {
        $this->middleware('auth');
        $this->attendanceRecordService = $attendanceRecordService;
    }

    /**
     * @OA\GET(
     *     path="/api/attendance-records",
     *     tags={"Attendance Records"},
     *     summary="Get Attendance Records list",
     *     description="Get Attendance Records List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(Request $request)
    {
        try {
            $this->authorize('viewAny', AttendanceRecord::class);

            $attendanceRecords = $this->attendanceRecordService->paginate($request->all());
            return AttendanceRecordResource::collection($attendanceRecords);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\GET(
     *     path="/api/attendance-records/{id}",
     *     tags={"Attendance Records"},
     *     summary="Get Attendance Record detail",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(Request $request, int $id)
    {
        try {
            $this->authorize('view', AttendanceRecord::class);

            $attendanceRecord = $this->attendanceRecordService->getOneOrFail($id, $request->all());
            return new AttendanceRecordResource($attendanceRecord);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\POST(
     *     path="/api/attendance-records",
     *     tags={"Attendance Records"},
     *     summary="Create a new Attendance Record",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function store(AttendanceRecordStoreRequest $request)
    {
        try {
            $this->authorize('create', AttendanceRecord::class);

            $payload = $request->validated();
            $attendanceRecord = $this->attendanceRecordService->createOne($payload);

            return new AttendanceRecordResource($attendanceRecord);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\PUT(
     *     path="/api/attendance-records/{id}",
     *     tags={"Attendance Records"},
     *     summary="Update an existing Attendance Record",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function update(AttendanceRecordUpdateRequest $request, int $id)
    {
        try {
            $this->authorize('update', AttendanceRecord::class);

            $payload = $request->validated();
            $attendanceRecord = $this->attendanceRecordService->updateOne($id, $payload);

            return new AttendanceRecordResource($attendanceRecord);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\DELETE(
     *     path="/api/attendance-records/{id}",
     *     tags={"Attendance Records"},
     *     summary="Delete a Attendance Record",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy(int $id)
    {
        try {
            $this->authorize('delete', AttendanceRecord::class);

            $attendanceRecord = $this->attendanceRecordService->deleteOne($id);
            return new AttendanceRecordResource($attendanceRecord);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\POST(
     *     path="/api/attendance-records/{id}/restore",
     *     tags={"Attendance Records"},
     *     summary="Restore a Attendance Record from trash",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function restore(int $id)
    {
        try {
            $this->authorize('restore', AttendanceRecord::class);

            $attendanceRecord = $this->attendanceRecordService->restoreOne($id);
            return new AttendanceRecordResource($attendanceRecord);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
