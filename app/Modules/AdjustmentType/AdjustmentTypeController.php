<?php

namespace App\Modules\AdjustmentType;

use App\Http\Controllers\Controller;
use App\Modules\AdjustmentType\AdjustmentTypeService;
use App\Modules\AdjustmentType\Resources\AdjustmentTypeResource;
use App\Modules\AdjustmentType\Requests\AdjustmentTypeStoreRequest;
use App\Modules\AdjustmentType\Requests\AdjustmentTypeUpdateRequest;
use Illuminate\Http\Request;

class AdjustmentTypeController extends Controller
{
    protected $adjustmentTypeService;

    public function __construct(AdjustmentTypeService $adjustmentTypeService)
    {
        $this->middleware('auth');
        $this->adjustmentTypeService = $adjustmentTypeService;
    }

    /**
     * @OA\GET(
     *     path="/api/adjustment-types",
     *     tags={"Adjustment Types"},
     *     summary="Get Adjustment Types list",
     *     description="Get Adjustment Types List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(Request $request)
    {
        try {
            $this->authorize('viewAny', AdjustmentType::class);
            
            $adjustmentTypes = $this->adjustmentTypeService->paginate($request->all());
            return AdjustmentTypeResource::collection($adjustmentTypes);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\GET(
     *     path="/api/adjustment-types/{id}",
     *     tags={"Adjustment Types"},
     *     summary="Get Adjustment Type detail",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(Request $request, int $id)
    {
        try {
            $this->authorize('view', AdjustmentType::class);

            $adjustmentType = $this->adjustmentTypeService->getOneOrFail($id, $request->all());
            return new AdjustmentTypeResource($adjustmentType);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\POST(
     *     path="/api/adjustment-types",
     *     tags={"Adjustment Types"},
     *     summary="Create a new Adjustment Type",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function store(AdjustmentTypeStoreRequest $request)
    {
        try {
            $this->authorize('create', AdjustmentType::class);

            $payload = $request->validated();
            $adjustmentType = $this->adjustmentTypeService->createOne($payload);

            return new AdjustmentTypeResource($adjustmentType);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\PUT(
     *     path="/api/adjustment-types/{id}",
     *     tags={"Adjustment Types"},
     *     summary="Update an existing Adjustment Type",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function update(AdjustmentTypeUpdateRequest $request, int $id)
    {
        try {
            $this->authorize('update', AdjustmentType::class);

            $payload = $request->validated();
            $adjustmentType = $this->adjustmentTypeService->updateOne($id, $payload);

            return new AdjustmentTypeResource($adjustmentType);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\DELETE(
     *     path="/api/adjustment-types/{id}",
     *     tags={"Adjustment Types"},
     *     summary="Delete a Adjustment Type",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy(int $id)
    {
        try {
            $this->authorize('delete', AdjustmentType::class);

            $adjustmentType = $this->adjustmentTypeService->deleteOne($id);
            return new AdjustmentTypeResource($adjustmentType);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\POST(
     *     path="/api/adjustment-types/{id}/restore",
     *     tags={"Adjustment Types"},
     *     summary="Restore a Adjustment Type from trash",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function restore(int $id)
    {
        try {
            $this->authorize('restore', AdjustmentType::class);

            $adjustmentType = $this->adjustmentTypeService->restoreOne($id);
            return new AdjustmentTypeResource($adjustmentType);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
