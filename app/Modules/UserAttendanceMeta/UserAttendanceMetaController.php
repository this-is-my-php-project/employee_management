<?php

namespace App\Modules\UserAttendanceMeta;

use App\Http\Controllers\Controller;
use App\Modules\UserAttendanceMeta\Requests\UserAttendanceMetaStoreManyRequest;
use App\Modules\UserAttendanceMeta\UserAttendanceMetaService;
use App\Modules\UserAttendanceMeta\Resources\UserAttendanceMetaResource;
use App\Modules\UserAttendanceMeta\Requests\UserAttendanceMetaStoreRequest;
use App\Modules\UserAttendanceMeta\Requests\UserAttendanceMetaUpdateRequest;
use Illuminate\Http\Request;

class UserAttendanceMetaController extends Controller
{
    protected $userAttendanceMetaService;

    public function __construct(UserAttendanceMetaService $userAttendanceMetaService)
    {
        $this->middleware('auth');
        $this->userAttendanceMetaService = $userAttendanceMetaService;
    }

    /**
     * @OA\GET(
     *     path="/api/user-attendance-meta",
     *     tags={"User Attendance Meta"},
     *     summary="Get User Attendance Meta list",
     *     description="Get User Attendance Meta List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(Request $request)
    {
        try {
            $this->authorize('viewAny', UserAttendanceMeta::class);

            $userAttendanceMeta = $this->userAttendanceMetaService->paginate($request->all());
            return UserAttendanceMetaResource::collection($userAttendanceMeta);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\GET(
     *     path="/api/user-attendance-meta/{id}",
     *     tags={"User Attendance Meta"},
     *     summary="Get User Attendance Meta detail",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(Request $request, int $id)
    {
        try {
            $this->authorize('view', UserAttendanceMeta::class);

            $userAttendanceMeta = $this->userAttendanceMetaService->getOneOrFail($id, $request->all());
            return new UserAttendanceMetaResource($userAttendanceMeta);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\POST(
     *     path="/api/user-attendance-meta",
     *     tags={"User Attendance Meta"},
     *     summary="Create a new User Attendance Meta",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function store(UserAttendanceMetaStoreRequest $request)
    {
        try {
            $this->authorize('create', UserAttendanceMeta::class);

            $payload = $request->validated();
            $userAttendanceMeta = $this->userAttendanceMetaService->createOne($payload);

            return new UserAttendanceMetaResource($userAttendanceMeta);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\POST(
     *     path="/api/many-user-attendance-meta",
     *     tags={"User Attendance Meta"},
     *     summary="Create a new User Attendance Meta",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function insertMany(UserAttendanceMetaStoreManyRequest $request)
    {
        try {
            $this->authorize('create', UserAttendanceMeta::class);

            $payload = $request->validated();
            $this->userAttendanceMetaService->insertMany($payload);

            return $this->sendSuccess('User Attendance Meta created successfully');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\PUT(
     *     path="/api/user-attendance-meta/{id}",
     *     tags={"User Attendance Meta"},
     *     summary="Update an existing User Attendance Meta",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function update(UserAttendanceMetaUpdateRequest $request, int $id)
    {
        try {
            $this->authorize('update', UserAttendanceMeta::class);

            $payload = $request->validated();
            $userAttendanceMeta = $this->userAttendanceMetaService->updateOne($id, $payload);

            return new UserAttendanceMetaResource($userAttendanceMeta);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\DELETE(
     *     path="/api/user-attendance-meta/{id}",
     *     tags={"User Attendance Meta"},
     *     summary="Delete a User Attendance Meta",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy(int $id)
    {
        try {
            $this->authorize('delete', UserAttendanceMeta::class);

            $userAttendanceMeta = $this->userAttendanceMetaService->deleteOne($id);
            return new UserAttendanceMetaResource($userAttendanceMeta);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\POST(
     *     path="/api/user-attendance-meta/{id}/restore",
     *     tags={"User Attendance Meta"},
     *     summary="Restore a User Attendance Meta from trash",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function restore(int $id)
    {
        try {
            $this->authorize('restore', UserAttendanceMeta::class);

            $userAttendanceMeta = $this->userAttendanceMetaService->restoreOne($id);
            return new UserAttendanceMetaResource($userAttendanceMeta);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
