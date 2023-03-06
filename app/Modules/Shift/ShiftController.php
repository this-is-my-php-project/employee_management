<?php

namespace App\Modules\Shift;

use App\Http\Controllers\Controller;
use App\Modules\Shift\Requests\AssignUserRequest;
use App\Modules\Shift\ShiftService;
use App\Modules\Shift\Resources\ShiftResource;
use App\Modules\Shift\Requests\ShiftStoreRequest;
use App\Modules\Shift\Requests\ShiftUpdateRequest;
use App\Modules\Shift\Requests\ShiftUserRequest;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    protected $shiftService;

    public function __construct(ShiftService $shiftService)
    {
        $this->middleware('auth');
        $this->shiftService = $shiftService;
    }

    /**
     * @OA\GET(
     *     path="/api/shifts",
     *     tags={"Shifts"},
     *     summary="Get Shifts list",
     *     description="Get Shifts List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(Request $request)
    {
        try {
            $this->authorize('viewAny', Shift::class);

            $shifts = $this->shiftService->paginate($request->all());
            return ShiftResource::collection($shifts);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\GET(
     *     path="/api/shifts/{id}",
     *     tags={"Shifts"},
     *     summary="Get Shift detail",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(Request $request, int $id)
    {
        try {
            $this->authorize('view', Shift::class);

            $shift = $this->shiftService->getOneOrFail($id, $request->all());
            return new ShiftResource($shift);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\POST(
     *     path="/api/shifts",
     *     tags={"Shifts"},
     *     summary="Create a new Shift",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function store(ShiftStoreRequest $request)
    {
        try {
            $payload = $request->validated();

            $this->authorize('create', [Shift::class, $payload['workspace_id']]);

            $shift = $this->shiftService->createOne($payload);

            return new ShiftResource($shift);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\PUT(
     *     path="/api/shifts/{id}",
     *     tags={"Shifts"},
     *     summary="Update an existing Shift",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function update(ShiftUpdateRequest $request, int $id)
    {
        try {
            $payload = $request->validated();

            $this->authorize('update', [Shift::class, $payload['workspace_id']]);

            $shift = $this->shiftService->updateOne($id, $payload);

            return new ShiftResource($shift);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\DELETE(
     *     path="/api/shifts/{id}",
     *     tags={"Shifts"},
     *     summary="Delete a Shift",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy(Request $request, int $id)
    {
        try {
            $request->validate([
                'workspace_id' => 'required|integer'
            ]);

            $this->authorize('delete', [Shift::class, $request->workspace_id]);

            $shift = $this->shiftService->deleteOne($id);
            return new ShiftResource($shift);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function assignUser(AssignUserRequest $request)
    {
        try {
            $payload = $request->validated();

            $this->authorize('assignUser', [Shift::class, $payload['workspace_id']]);

            $this->shiftService->assignUser($payload);
            return $this->sendSuccess('User assigned to shift successfully');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function getShifts(ShiftUserRequest $request)
    {
        try {
            $payload = $request->validated();

            $this->authorize('viewWorkspaceShifts', [Shift::class, $payload['workspace_id']]);

            $shifts = $this->shiftService->getWorkspaceShifts($payload['workspace_id']);

            return $this->sendSuccess('Shifts fetched successfully', $shifts);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
