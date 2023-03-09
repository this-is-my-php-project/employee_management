<?php

namespace App\Modules\Adjustment;

use App\Http\Controllers\Controller;
use App\Modules\Adjustment\AdjustmentService;
use App\Modules\Adjustment\Resources\AdjustmentResource;
use App\Modules\Adjustment\Requests\AdjustmentStoreRequest;
use App\Modules\Adjustment\Requests\AdjustmentUpdateRequest;
use App\Modules\Profile\Profile;
use Illuminate\Http\Request;

class AdjustmentController extends Controller
{
    protected $adjustmentService;

    public function __construct(AdjustmentService $adjustmentService)
    {
        $this->middleware('auth');
        $this->adjustmentService = $adjustmentService;
    }

    public function getAdjustments(Request $request)
    {
        try {
            $request->validate([
                'workspace_id' => 'required|exists:workspaces,id,',
            ]);

            $this->authorize('viewWorkspaceAdjustment', [Adjustment::class, $request->workspace_id]);

            $adjustments = Adjustment::where('workspace_id', $request->workspace_id)->get();

            return response()->json([
                'status' => 200,
                'message' => 'success',
                'data' => $adjustments,
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function getAdjustmentInfo(Request $request)
    {
        try {
            $request->validate([
                'workspace_id' => 'required|exists:workspaces,id',
            ]);

            $profile = Profile::getProfile($request->workspace_id);

            $adjustments = Adjustment::where('workspace_id', $request->workspace_id)
                ->where('profile_id', $profile->id)
                ->get();

            return response()->json([
                'status' => 200,
                'message' => 'success',
                'data' => $adjustments,
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
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
}
