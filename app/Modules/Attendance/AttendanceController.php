<?php

namespace App\Modules\Attendance;

use App\Http\Controllers\Controller;
use App\Modules\Attendance\AttendanceService;
use App\Modules\Attendance\Resources\AttendanceResource;
use App\Modules\Attendance\Requests\AttendanceStoreRequest;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    protected $attendanceService;

    public function __construct(AttendanceService $attendanceService)
    {
        $this->middleware('auth');
        $this->attendanceService = $attendanceService;
    }

    /**
     * @OA\GET(
     *     path="/api/attendances",
     *     tags={"Attendances"},
     *     summary="Get Attendances list",
     *     description="Get Attendances List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(Request $request)
    {
        try {
            $this->authorize('viewAny', Attendance::class);

            $attendances = $this->attendanceService->paginate($request->all());
            return AttendanceResource::collection($attendances);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\GET(
     *     path="/api/attendances/{id}",
     *     tags={"Attendances"},
     *     summary="Get Attendance detail",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(Request $request, int $id)
    {
        try {
            $this->authorize('view', Attendance::class);

            $attendance = $this->attendanceService->getOneOrFail($id, $request->all());
            return new AttendanceResource($attendance);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\POST(
     *     path="/api/attendances/check-in",
     *     tags={"Attendances"},
     *     summary="Create a new Attendance",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function store(AttendanceStoreRequest $request)
    {
        try {
            $this->authorize('create', Attendance::class);

            $payload = $request->validated();
            $attendance = $this->attendanceService->createOne($payload);

            return new AttendanceResource($attendance);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
