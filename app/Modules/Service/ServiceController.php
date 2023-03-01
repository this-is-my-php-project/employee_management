<?php

namespace App\Modules\Service;

use App\Http\Controllers\Controller;
use App\Modules\Service\ServiceService;
use App\Modules\Service\Resources\ServiceResource;
use App\Modules\Service\Requests\ServiceStoreRequest;
use App\Modules\Service\Requests\ServiceUpdateRequest;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    protected $serviceService;

    public function __construct(ServiceService $serviceService)
    {
        $this->middleware('auth');
        $this->serviceService = $serviceService;
    }

    /**
     * @OA\GET(
     *     path="/api/services",
     *     tags={"Services"},
     *     summary="Get Services list",
     *     description="Get Services List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(Request $request)
    {
        try {
            $this->authorize('viewAny', Service::class);
            
            $services = $this->serviceService->paginate($request->all());
            return ServiceResource::collection($services);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\GET(
     *     path="/api/services/{id}",
     *     tags={"Services"},
     *     summary="Get Service detail",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(Request $request, int $id)
    {
        try {
            $this->authorize('view', Service::class);

            $service = $this->serviceService->getOneOrFail($id, $request->all());
            return new ServiceResource($service);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\POST(
     *     path="/api/services",
     *     tags={"Services"},
     *     summary="Create a new Service",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function store(ServiceStoreRequest $request)
    {
        try {
            $this->authorize('create', Service::class);

            $payload = $request->validated();
            $service = $this->serviceService->createOne($payload);

            return new ServiceResource($service);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\PUT(
     *     path="/api/services/{id}",
     *     tags={"Services"},
     *     summary="Update an existing Service",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function update(ServiceUpdateRequest $request, int $id)
    {
        try {
            $this->authorize('update', Service::class);

            $payload = $request->validated();
            $service = $this->serviceService->updateOne($id, $payload);

            return new ServiceResource($service);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\DELETE(
     *     path="/api/services/{id}",
     *     tags={"Services"},
     *     summary="Delete a Service",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy(int $id)
    {
        try {
            $this->authorize('delete', Service::class);

            $service = $this->serviceService->deleteOne($id);
            return new ServiceResource($service);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\POST(
     *     path="/api/services/{id}/restore",
     *     tags={"Services"},
     *     summary="Restore a Service from trash",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function restore(int $id)
    {
        try {
            $this->authorize('restore', Service::class);

            $service = $this->serviceService->restoreOne($id);
            return new ServiceResource($service);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
