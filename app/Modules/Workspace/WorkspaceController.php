<?php

namespace App\Modules\Workspace;

use App\Http\Controllers\Controller;
use App\Modules\Workspace\Requests\WorkspaceInviteRequest;
use App\Modules\Workspace\WorkspaceService;
use App\Modules\Workspace\Resources\WorkspaceResource;
use App\Modules\Workspace\Requests\WorkspaceStoreRequest;
use App\Modules\Workspace\Requests\WorkspaceUpdateRequest;
use Illuminate\Http\Request;

class WorkspaceController extends Controller
{
    protected $workspaceService;

    public function __construct(WorkspaceService $workspaceService)
    {
        $this->middleware('auth');
        $this->workspaceService = $workspaceService;
    }

    /**
     * @OA\GET(
     *     path="/api/workspaces",
     *     tags={"Workspaces"},
     *     summary="Get Workspaces list",
     *     description="Get Workspaces List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(Request $request)
    {
        try {
            $this->authorize('viewAny', Workspace::class);

            $workspaces = $this->workspaceService->paginate($request->all());

            return WorkspaceResource::collection($workspaces);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\GET(
     *     path="/api/workspaces/{id}",
     *     tags={"Workspaces"},
     *     summary="Get Workspace detail",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(Request $request, int $id)
    {
        try {
            $this->authorize('view', Workspace::class);

            $workspace = $this->workspaceService->getOneOrFail($id, $request->all());
            return new WorkspaceResource($workspace);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\POST(
     *     path="/api/workspaces",
     *     tags={"Workspaces"},
     *     summary="Create a new Workspace",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function store(WorkspaceStoreRequest $request)
    {
        try {
            $this->authorize('create', Workspace::class);

            $payload = $request->validated();
            $workspace = $this->workspaceService->createOne($payload);

            return new WorkspaceResource($workspace);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\PUT(
     *     path="/api/workspaces/{id}",
     *     tags={"Workspaces"},
     *     summary="Update an existing Workspace",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function update(WorkspaceUpdateRequest $request, int $id)
    {
        try {
            $this->authorize('update', Workspace::class);

            $payload = $request->validated();
            $workspace = $this->workspaceService->updateOne($id, $payload);

            return new WorkspaceResource($workspace);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\DELETE(
     *     path="/api/workspaces/{id}",
     *     tags={"Workspaces"},
     *     summary="Delete a Workspace",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy(int $id)
    {
        try {
            $this->authorize('delete', Workspace::class);

            $workspace = $this->workspaceService->deleteOne($id);
            return new WorkspaceResource($workspace);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\POST(
     *     path="/api/workspaces/{id}/restore",
     *     tags={"Workspaces"},
     *     summary="Restore a Workspace from trash",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function restore(int $id)
    {
        try {
            $this->authorize('restore', Workspace::class);

            $workspace = $this->workspaceService->restoreOne($id);
            return new WorkspaceResource($workspace);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\POST(
     *     path="/api/add-to-workspace",
     *     tags={"Workspaces"},
     *     summary="Invite a user to a workspace",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function addToWorkspace(WorkspaceInviteRequest $request)
    {
        try {
            if (!$request->hasValidSignature()) {
                return $this->sendError('Invalid invite link');
            }

            $payload = $request->validated();
            $workspace = $this->workspaceService->addToWorkspace($payload);

            return new WorkspaceResource($workspace);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\POST(
     *    path="/api/my-workspaces",
     *    tags={"Workspaces"},
     *    summary="Get my workspaces",
     *    @OA\Response(response=400, description="Bad request"),
     *    @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function myWorkspaces()
    {
        try {
            $workspaces = $this->workspaceService->myWorkspaces();

            return WorkspaceResource::collection($workspaces);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\POST(
     *   path="/api/invitations",
     *   tags={"Workspaces"},
     *   summary="Get invitations",
     *   @OA\Response(response=400, description="Bad request"),
     *   @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function invitations(WorkspaceInviteRequest $request)
    {
        try {
            $payload = $request->validated();
            $url = $this->workspaceService->invitations($payload);

            return response()->json(['url' => $url]);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function getInvitationUrl(WorkspaceInviteRequest $request)
    {
        try {
            $payload = $request->validated();
            $url = $this->workspaceService->getInvitationUrl($payload);

            return response()->json(['url' => $url]);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
