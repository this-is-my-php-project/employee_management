<?php

namespace App\Modules\InvitationUrl;

use App\Http\Controllers\Controller;
use App\Modules\InvitationUrl\InvitationUrlService;
use App\Modules\InvitationUrl\Requests\InvitationForWorkspace;
use App\Modules\InvitationUrl\Resources\InvitationUrlResource;
use App\Modules\InvitationUrl\Requests\InvitationUrlStoreRequest;
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
     *   path="/api/generate-url,
     *   tags={"Workspaces"},
     *   summary="Generate invitation url",
     *   @OA\Response(response=400, description="Bad request"),
     *   @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function generateUrl(InvitationUrlStoreRequest $request)
    {
        try {
            $this->authorize('reset', InvitationUrl::class);

            $payload = $request->validated();
            $url = $this->invitationUrlService->generateUrl($payload);

            return $this->sendSuccess('Invitation url generated successfully', ['url' => $url]);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\POST(
     *   path="/api/invitation-url",
     *   tags={"Workspaces"},
     *   summary="Validate invitation",
     *   @OA\Response(response=400, description="Bad request"),
     *   @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getInvitationUrl(InvitationForWorkspace $request)
    {
        try {
            $this->authorize('reset', InvitationUrl::class);

            $payload = $request->validated();
            $url = $this->invitationUrlService->getInvitationUrlForWorkspace($payload);
            if (empty($url)) {
                return $this->sendError('Invitation url not exist');
            }

            return new InvitationUrlResource($url);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function resetInvitationUrl(InvitationForWorkspace $request)
    {
        try {
            $this->authorize('reset', InvitationUrl::class);

            $payload = $request->validated();
            $this->invitationUrlService->resetInvitationUrl($payload['workspace_id']);

            return $this->sendSuccess('Invitation url reset successfully');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
