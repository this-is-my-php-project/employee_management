<?php

namespace App\Modules\InvitationUrl;

use App\Http\Controllers\Controller;
use App\Modules\InvitationUrl\InvitationUrlService;
use App\Modules\InvitationUrl\Requests\InvitationForWorkspace;
use App\Modules\InvitationUrl\Resources\InvitationUrlResource;
use App\Modules\InvitationUrl\Requests\InvitationUrlStoreRequest;
use App\Modules\InvitationUrl\Requests\InvitationUrlUpdateRequest;
use Illuminate\Http\Request;

class InvitationUrlController extends Controller
{
    protected $invitationUrlService;

    public function __construct(InvitationUrlService $invitationUrlService)
    {
        $this->middleware('auth');
        $this->invitationUrlService = $invitationUrlService;
    }

    /**
     * @OA\GET(
     *     path="/api/invitation-urls",
     *     tags={"Invitation Urls"},
     *     summary="Get Invitation Urls list",
     *     description="Get Invitation Urls List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(Request $request)
    {
        try {
            $this->authorize('viewAny', InvitationUrl::class);

            $invitationUrls = $this->invitationUrlService->paginate($request->all());
            return InvitationUrlResource::collection($invitationUrls);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\GET(
     *     path="/api/invitation-urls/{id}",
     *     tags={"Invitation Urls"},
     *     summary="Get Invitation Url detail",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(Request $request, int $id)
    {
        try {
            $this->authorize('view', InvitationUrl::class);

            $invitationUrl = $this->invitationUrlService->getOneOrFail($id, $request->all());
            return new InvitationUrlResource($invitationUrl);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\POST(
     *     path="/api/invitation-urls",
     *     tags={"Invitation Urls"},
     *     summary="Create a new Invitation Url",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function store(InvitationUrlStoreRequest $request)
    {
        try {
            $this->authorize('create', InvitationUrl::class);

            $payload = $request->validated();
            $invitationUrl = $this->invitationUrlService->createOne($payload);

            return new InvitationUrlResource($invitationUrl);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\PUT(
     *     path="/api/invitation-urls/{id}",
     *     tags={"Invitation Urls"},
     *     summary="Update an existing Invitation Url",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function update(InvitationUrlUpdateRequest $request, int $id)
    {
        try {
            $this->authorize('update', InvitationUrl::class);

            $payload = $request->validated();
            $invitationUrl = $this->invitationUrlService->updateOne($id, $payload);

            return new InvitationUrlResource($invitationUrl);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\DELETE(
     *     path="/api/invitation-urls/{id}",
     *     tags={"Invitation Urls"},
     *     summary="Delete a Invitation Url",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy(int $id)
    {
        try {
            $this->authorize('delete', InvitationUrl::class);

            $invitationUrl = $this->invitationUrlService->deleteOne($id);
            return new InvitationUrlResource($invitationUrl);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\POST(
     *     path="/api/invitation-urls/{id}/restore",
     *     tags={"Invitation Urls"},
     *     summary="Restore a Invitation Url from trash",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function restore(int $id)
    {
        try {
            $this->authorize('restore', InvitationUrl::class);

            $invitationUrl = $this->invitationUrlService->restoreOne($id);
            return new InvitationUrlResource($invitationUrl);
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
    public function generateUrl(InvitationUrlStoreRequest $request)
    {
        try {
            $payload = $request->validated();
            $url = $this->invitationUrlService->generateUrl($payload);

            return response()->json(['url' => $url]);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function getInvitationUrl(InvitationForWorkspace $request)
    {
        try {
            $payload = $request->validated();
            $url = $this->invitationUrlService->getInvitationUrl($payload);

            return response()->json(['url' => $url]);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
