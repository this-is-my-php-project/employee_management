<?php

namespace App\Modules\Service/LeaveService;

use App\Http\Controllers\Controller;
use App\Modules\Service/LeaveService\Service/LeaveServiceService;
use App\Modules\Service/LeaveService\Resources\Service/LeaveServiceResource;
use App\Modules\Service/LeaveService\Requests\Service/LeaveServiceStoreRequest;
use App\Modules\Service/LeaveService\Requests\Service/LeaveServiceUpdateRequest;
use Illuminate\Http\Request;

class Service/LeaveServiceController extends Controller
{
    protected $service/LeaveServiceService;

    public function __construct(Service/LeaveServiceService $service/LeaveServiceService)
    {
        $this->middleware('auth');
        $this->service/LeaveServiceService = $service/LeaveServiceService;
    }

    /**
     * @OA\GET(
     *     path="/api/service-leave-services",
     *     tags={"Service/ Leave Services"},
     *     summary="Get Service/ Leave Services list",
     *     description="Get Service/ Leave Services List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(Request $request)
    {
        try {
            $this->authorize('viewAny', Service/LeaveService::class);
            
            $service/LeaveServices = $this->service/LeaveServiceService->paginate($request->all());
            return Service/LeaveServiceResource::collection($service/LeaveServices);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\GET(
     *     path="/api/service-leave-services/{id}",
     *     tags={"Service/ Leave Services"},
     *     summary="Get Service/ Leave Service detail",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(Request $request, int $id)
    {
        try {
            $this->authorize('view', Service/LeaveService::class);

            $service/LeaveService = $this->service/LeaveServiceService->getOneOrFail($id, $request->all());
            return new Service/LeaveServiceResource($service/LeaveService);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\POST(
     *     path="/api/service-leave-services",
     *     tags={"Service/ Leave Services"},
     *     summary="Create a new Service/ Leave Service",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function store(Service/LeaveServiceStoreRequest $request)
    {
        try {
            $this->authorize('create', Service/LeaveService::class);

            $payload = $request->validated();
            $service/LeaveService = $this->service/LeaveServiceService->createOne($payload);

            return new Service/LeaveServiceResource($service/LeaveService);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\PUT(
     *     path="/api/service-leave-services/{id}",
     *     tags={"Service/ Leave Services"},
     *     summary="Update an existing Service/ Leave Service",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function update(Service/LeaveServiceUpdateRequest $request, int $id)
    {
        try {
            $this->authorize('update', Service/LeaveService::class);

            $payload = $request->validated();
            $service/LeaveService = $this->service/LeaveServiceService->updateOne($id, $payload);

            return new Service/LeaveServiceResource($service/LeaveService);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\DELETE(
     *     path="/api/service-leave-services/{id}",
     *     tags={"Service/ Leave Services"},
     *     summary="Delete a Service/ Leave Service",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy(int $id)
    {
        try {
            $this->authorize('delete', Service/LeaveService::class);

            $service/LeaveService = $this->service/LeaveServiceService->deleteOne($id);
            return new Service/LeaveServiceResource($service/LeaveService);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\POST(
     *     path="/api/service-leave-services/{id}/restore",
     *     tags={"Service/ Leave Services"},
     *     summary="Restore a Service/ Leave Service from trash",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function restore(int $id)
    {
        try {
            $this->authorize('restore', Service/LeaveService::class);

            $service/LeaveService = $this->service/LeaveServiceService->restoreOne($id);
            return new Service/LeaveServiceResource($service/LeaveService);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
