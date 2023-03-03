<?php

namespace App\Modules\Adjustment;

use App\Http\Controllers\Controller;
use App\Modules\Adjustment\AdjustmentService;
use App\Modules\Adjustment\Resources\AdjustmentResource;
use App\Modules\Adjustment\Requests\AdjustmentStoreRequest;
use App\Modules\Adjustment\Requests\AdjustmentUpdateRequest;
use Illuminate\Http\Request;

class AdjustmentController extends Controller
{
    protected $adjustmentService;

    public function __construct(AdjustmentService $adjustmentService)
    {
        $this->middleware('auth');
        $this->adjustmentService = $adjustmentService;
    }

    /**
     * @OA\GET(
     *     path="/api/adjustments",
     *     tags={"Adjustments"},
     *     summary="Get Adjustments list",
     *     description="Get Adjustments List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(Request $request)
    {
        try {
            $this->authorize('viewAny', Adjustment::class);
            
            $adjustments = $this->adjustmentService->paginate($request->all());
            return AdjustmentResource::collection($adjustments);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\GET(
     *     path="/api/adjustments/{id}",
     *     tags={"Adjustments"},
     *     summary="Get Adjustment detail",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(Request $request, int $id)
    {
        try {
            $this->authorize('view', Adjustment::class);

            $adjustment = $this->adjustmentService->getOneOrFail($id, $request->all());
            return new AdjustmentResource($adjustment);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\POST(
     *     path="/api/adjustments",
     *     tags={"Adjustments"},
     *     summary="Create a new Adjustment",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function store(AdjustmentStoreRequest $request)
    {
        try {
            $this->authorize('create', Adjustment::class);

            $payload = $request->validated();
            $adjustment = $this->adjustmentService->createOne($payload);

            return new AdjustmentResource($adjustment);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\PUT(
     *     path="/api/adjustments/{id}",
     *     tags={"Adjustments"},
     *     summary="Update an existing Adjustment",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function update(AdjustmentUpdateRequest $request, int $id)
    {
        try {
            $this->authorize('update', Adjustment::class);

            $payload = $request->validated();
            $adjustment = $this->adjustmentService->updateOne($id, $payload);

            return new AdjustmentResource($adjustment);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\DELETE(
     *     path="/api/adjustments/{id}",
     *     tags={"Adjustments"},
     *     summary="Delete a Adjustment",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy(int $id)
    {
        try {
            $this->authorize('delete', Adjustment::class);

            $adjustment = $this->adjustmentService->deleteOne($id);
            return new AdjustmentResource($adjustment);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\POST(
     *     path="/api/adjustments/{id}/restore",
     *     tags={"Adjustments"},
     *     summary="Restore a Adjustment from trash",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function restore(int $id)
    {
        try {
            $this->authorize('restore', Adjustment::class);

            $adjustment = $this->adjustmentService->restoreOne($id);
            return new AdjustmentResource($adjustment);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
