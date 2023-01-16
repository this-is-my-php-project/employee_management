<?php

namespace App\Modules\Storage;

use App\Http\Controllers\Controller;
use App\Modules\Storage\StorageService;
use App\Modules\Storage\Resources\StorageResource;
use App\Modules\Storage\Requests\StorageIndexRequest;
use App\Modules\Storage\Requests\StorageStoreRequest;
use App\Modules\Storage\Requests\StorageUpdateRequest;

class StorageController extends Controller
{
    protected $storageService;

    public function __construct(StorageService $storageService)
    {
        $this->middleware('auth');
        $this->storageService = $storageService;
    }

    /**
     * @OA\GET(
     *     path="/api/storages",
     *     tags={"Storages"},
     *     summary="Get Storages list",
     *     description="Get Storages List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(StorageIndexRequest $request)
    {
        try {
            $this->authorize('viewAny', Storage::class);

            $storages = $this->storageService->paginate($request->all());
            return StorageResource::collection($storages);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\GET(
     *     path="/api/storages/{id}",
     *     tags={"Storages"},
     *     summary="Get Storage detail",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(StorageIndexRequest $request, int $id)
    {
        try {
        $this->authorize('view', Storage::class);

        $storage = $this->storageService->getOneOrFail($id, $request->all());
        return new StorageResource($storage);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\POST(
     *     path="/api/storages",
     *     tags={"Storages"},
     *     summary="Create a new Storage",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function store(StorageStoreRequest $request)
    {
        try {
        $this->authorize('create', Storage::class);

        $storage = $this->storageService->createOne($request->all());
        return new StorageResource($storage);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\PUT(
     *     path="/api/storages/{id}",
     *     tags={"Storages"},
     *     summary="Update an existing Storage",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function update(StorageUpdateRequest $request, int $id)
    {
        try {
        $this->authorize('update', Storage::class);

        $storage = $this->storageService->updateOne($id, $request->all());
        return new StorageResource($storage);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\DELETE(
     *     path="/api/storages/{id}",
     *     tags={"Storages"},
     *     summary="Delete a Storage",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy(int $id)
    {
        try {
        $this->authorize('delete', Storage::class);

        $storage = $this->storageService->deleteOne($id);
        return new StorageResource($storage);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\POST(
     *     path="/api/storages/{id}/restore",
     *     tags={"Storages"},
     *     summary="Restore a Storage from trash",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function restore(int $id)
    {
        try {
        $this->authorize('restore', Storage::class);

        $storage = $this->storageService->restoreOne($id);
        return new StorageResource($storage);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
