<?php

namespace App\Modules\Service/ApprovalService;

use App\Http\Controllers\Controller;
use App\Modules\Service/ApprovalService\Service/ApprovalServiceService;
use App\Modules\Service/ApprovalService\Resources\Service/ApprovalServiceResource;
use App\Modules\Service/ApprovalService\Requests\Service/ApprovalServiceStoreRequest;
use App\Modules\Service/ApprovalService\Requests\Service/ApprovalServiceUpdateRequest;
use Illuminate\Http\Request;

class Service/ApprovalServiceController extends Controller
{
    protected $service/ApprovalServiceService;

    public function __construct(Service/ApprovalServiceService $service/ApprovalServiceService)
    {
        $this->middleware('auth');
        $this->service/ApprovalServiceService = $service/ApprovalServiceService;
    }

    /**
     * @OA\GET(
     *     path="/api/service-approval-services",
     *     tags={"Service/ Approval Services"},
     *     summary="Get Service/ Approval Services list",
     *     description="Get Service/ Approval Services List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(Request $request)
    {
        try {
            $this->authorize('viewAny', Service/ApprovalService::class);
            
            $service/ApprovalServices = $this->service/ApprovalServiceService->paginate($request->all());
            return Service/ApprovalServiceResource::collection($service/ApprovalServices);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\GET(
     *     path="/api/service-approval-services/{id}",
     *     tags={"Service/ Approval Services"},
     *     summary="Get Service/ Approval Service detail",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(Request $request, int $id)
    {
        try {
            $this->authorize('view', Service/ApprovalService::class);

            $service/ApprovalService = $this->service/ApprovalServiceService->getOneOrFail($id, $request->all());
            return new Service/ApprovalServiceResource($service/ApprovalService);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\POST(
     *     path="/api/service-approval-services",
     *     tags={"Service/ Approval Services"},
     *     summary="Create a new Service/ Approval Service",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function store(Service/ApprovalServiceStoreRequest $request)
    {
        try {
            $this->authorize('create', Service/ApprovalService::class);

            $payload = $request->validated();
            $service/ApprovalService = $this->service/ApprovalServiceService->createOne($payload);

            return new Service/ApprovalServiceResource($service/ApprovalService);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\PUT(
     *     path="/api/service-approval-services/{id}",
     *     tags={"Service/ Approval Services"},
     *     summary="Update an existing Service/ Approval Service",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function update(Service/ApprovalServiceUpdateRequest $request, int $id)
    {
        try {
            $this->authorize('update', Service/ApprovalService::class);

            $payload = $request->validated();
            $service/ApprovalService = $this->service/ApprovalServiceService->updateOne($id, $payload);

            return new Service/ApprovalServiceResource($service/ApprovalService);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\DELETE(
     *     path="/api/service-approval-services/{id}",
     *     tags={"Service/ Approval Services"},
     *     summary="Delete a Service/ Approval Service",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy(int $id)
    {
        try {
            $this->authorize('delete', Service/ApprovalService::class);

            $service/ApprovalService = $this->service/ApprovalServiceService->deleteOne($id);
            return new Service/ApprovalServiceResource($service/ApprovalService);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\POST(
     *     path="/api/service-approval-services/{id}/restore",
     *     tags={"Service/ Approval Services"},
     *     summary="Restore a Service/ Approval Service from trash",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function restore(int $id)
    {
        try {
            $this->authorize('restore', Service/ApprovalService::class);

            $service/ApprovalService = $this->service/ApprovalServiceService->restoreOne($id);
            return new Service/ApprovalServiceResource($service/ApprovalService);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
