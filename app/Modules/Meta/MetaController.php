<?php

namespace App\Modules\Meta;

use App\Http\Controllers\Controller;
use App\Modules\Meta\MetaService;
use App\Modules\Meta\Resources\MetaResource;
use App\Modules\Meta\Requests\MetaStoreRequest;
use App\Modules\Meta\Requests\MetaUpdateRequest;
use Illuminate\Http\Request;

class MetaController extends Controller
{
    protected $metaService;

    public function __construct(MetaService $metaService)
    {
        $this->middleware('auth');
        $this->metaService = $metaService;
    }

    /**
     * @OA\GET(
     *     path="/api/meta",
     *     tags={"Meta"},
     *     summary="Get Meta list",
     *     description="Get Meta List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(Request $request)
    {
        try {
            $this->authorize('viewAny', Meta::class);

            $meta = $this->metaService->paginate($request->all());
            return MetaResource::collection($meta);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\GET(
     *     path="/api/meta/{id}",
     *     tags={"Meta"},
     *     summary="Get Meta detail",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(Request $request, int $id)
    {
        try {
            $this->authorize('view', Meta::class);

            $meta = $this->metaService->getOneOrFail($id, $request->all());
            return new MetaResource($meta);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\POST(
     *     path="/api/meta",
     *     tags={"Meta"},
     *     summary="Create a new Meta",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function store(MetaStoreRequest $request)
    {
        try {
            $this->authorize('create', Meta::class);

            $payload = $request->validated();
            $meta = $this->metaService->createOne($payload);

            return new MetaResource($meta);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\PUT(
     *     path="/api/meta/{id}",
     *     tags={"Meta"},
     *     summary="Update an existing Meta",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function update(MetaUpdateRequest $request, int $id)
    {
        try {
            $this->authorize('update', Meta::class);

            $payload = $request->validated();
            $meta = $this->metaService->updateOne($id, $payload);

            return new MetaResource($meta);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\DELETE(
     *     path="/api/meta/{id}",
     *     tags={"Meta"},
     *     summary="Delete a Meta",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy(int $id)
    {
        try {
            $this->authorize('delete', Meta::class);

            $meta = $this->metaService->deleteOne($id);
            return new MetaResource($meta);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\POST(
     *     path="/api/meta/{id}/restore",
     *     tags={"Meta"},
     *     summary="Restore a Meta from trash",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function restore(int $id)
    {
        try {
            $this->authorize('restore', Meta::class);

            $meta = $this->metaService->restoreOne($id);
            return new MetaResource($meta);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
