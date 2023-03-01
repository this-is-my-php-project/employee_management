<?php

namespace App\Modules\Service/ShiftService;

use App\Http\Controllers\Controller;
use App\Modules\Service/ShiftService\Service/ShiftServiceService;
use App\Modules\Service/ShiftService\Resources\Service/ShiftServiceResource;
use App\Modules\Service/ShiftService\Requests\Service/ShiftServiceStoreRequest;
use App\Modules\Service/ShiftService\Requests\Service/ShiftServiceUpdateRequest;
use Illuminate\Http\Request;

class Service/ShiftServiceController extends Controller
{
    protected $service/ShiftServiceService;

    public function __construct(Service/ShiftServiceService $service/ShiftServiceService)
    {
        $this->middleware('auth');
        $this->service/ShiftServiceService = $service/ShiftServiceService;
    }

    /**
     * @OA\GET(
     *     path="/api/service-shift-services",
     *     tags={"Service/ Shift Services"},
     *     summary="Get Service/ Shift Services list",
     *     description="Get Service/ Shift Services List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(Request $request)
    {
        try {
            $this->authorize('viewAny', Service/ShiftService::class);
            
            $service/ShiftServices = $this->service/ShiftServiceService->paginate($request->all());
            return Service/ShiftServiceResource::collection($service/ShiftServices);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\GET(
     *     path="/api/service-shift-services/{id}",
     *     tags={"Service/ Shift Services"},
     *     summary="Get Service/ Shift Service detail",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(Request $request, int $id)
    {
        try {
            $this->authorize('view', Service/ShiftService::class);

            $service/ShiftService = $this->service/ShiftServiceService->getOneOrFail($id, $request->all());
            return new Service/ShiftServiceResource($service/ShiftService);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\POST(
     *     path="/api/service-shift-services",
     *     tags={"Service/ Shift Services"},
     *     summary="Create a new Service/ Shift Service",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function store(Service/ShiftServiceStoreRequest $request)
    {
        try {
            $this->authorize('create', Service/ShiftService::class);

            $payload = $request->validated();
            $service/ShiftService = $this->service/ShiftServiceService->createOne($payload);

            return new Service/ShiftServiceResource($service/ShiftService);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\PUT(
     *     path="/api/service-shift-services/{id}",
     *     tags={"Service/ Shift Services"},
     *     summary="Update an existing Service/ Shift Service",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function update(Service/ShiftServiceUpdateRequest $request, int $id)
    {
        try {
            $this->authorize('update', Service/ShiftService::class);

            $payload = $request->validated();
            $service/ShiftService = $this->service/ShiftServiceService->updateOne($id, $payload);

            return new Service/ShiftServiceResource($service/ShiftService);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\DELETE(
     *     path="/api/service-shift-services/{id}",
     *     tags={"Service/ Shift Services"},
     *     summary="Delete a Service/ Shift Service",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy(int $id)
    {
        try {
            $this->authorize('delete', Service/ShiftService::class);

            $service/ShiftService = $this->service/ShiftServiceService->deleteOne($id);
            return new Service/ShiftServiceResource($service/ShiftService);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\POST(
     *     path="/api/service-shift-services/{id}/restore",
     *     tags={"Service/ Shift Services"},
     *     summary="Restore a Service/ Shift Service from trash",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function restore(int $id)
    {
        try {
            $this->authorize('restore', Service/ShiftService::class);

            $service/ShiftService = $this->service/ShiftServiceService->restoreOne($id);
            return new Service/ShiftServiceResource($service/ShiftService);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
