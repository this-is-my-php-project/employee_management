<?php

namespace App\Modules\Adjust;

use App\Http\Controllers\Controller;
use App\Modules\Adjust\AdjustService;
use App\Modules\Adjust\Resources\AdjustResource;
use App\Modules\Adjust\Requests\AdjustStoreRequest;
use App\Modules\Adjust\Requests\AdjustUpdateRequest;
use Illuminate\Http\Request;

class AdjustController extends Controller
{
    protected $adjustService;

    public function __construct(AdjustService $adjustService)
    {
        $this->middleware('auth');
        $this->adjustService = $adjustService;
    }

    /**
     * @OA\GET(
     *     path="/api/adjusts",
     *     tags={"Adjusts"},
     *     summary="Get Adjusts list",
     *     description="Get Adjusts List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(Request $request)
    {
        try {
            $this->authorize('viewAny', Adjust::class);
            
            $adjusts = $this->adjustService->paginate($request->all());
            return AdjustResource::collection($adjusts);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\GET(
     *     path="/api/adjusts/{id}",
     *     tags={"Adjusts"},
     *     summary="Get Adjust detail",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(Request $request, int $id)
    {
        try {
            $this->authorize('view', Adjust::class);

            $adjust = $this->adjustService->getOneOrFail($id, $request->all());
            return new AdjustResource($adjust);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\POST(
     *     path="/api/adjusts",
     *     tags={"Adjusts"},
     *     summary="Create a new Adjust",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function store(AdjustStoreRequest $request)
    {
        try {
            $this->authorize('create', Adjust::class);

            $payload = $request->validated();
            $adjust = $this->adjustService->createOne($payload);

            return new AdjustResource($adjust);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\PUT(
     *     path="/api/adjusts/{id}",
     *     tags={"Adjusts"},
     *     summary="Update an existing Adjust",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function update(AdjustUpdateRequest $request, int $id)
    {
        try {
            $this->authorize('update', Adjust::class);

            $payload = $request->validated();
            $adjust = $this->adjustService->updateOne($id, $payload);

            return new AdjustResource($adjust);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\DELETE(
     *     path="/api/adjusts/{id}",
     *     tags={"Adjusts"},
     *     summary="Delete a Adjust",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy(int $id)
    {
        try {
            $this->authorize('delete', Adjust::class);

            $adjust = $this->adjustService->deleteOne($id);
            return new AdjustResource($adjust);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\POST(
     *     path="/api/adjusts/{id}/restore",
     *     tags={"Adjusts"},
     *     summary="Restore a Adjust from trash",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function restore(int $id)
    {
        try {
            $this->authorize('restore', Adjust::class);

            $adjust = $this->adjustService->restoreOne($id);
            return new AdjustResource($adjust);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
