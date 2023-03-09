<?php

namespace App\Modules\Profile;

use App\Http\Controllers\Controller;
use App\Modules\Profile\ProfileService;
use App\Modules\Profile\Requests\ProfileGetRequest;
use App\Modules\Profile\Resources\ProfileResource;
use App\Modules\Profile\Requests\ProfileUpdateRequest;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    protected $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->middleware('auth');
        $this->profileService = $profileService;
    }

    public function getProfiles(ProfileGetRequest $request)
    {
        try {
            $payload = $request->validated();

            $profiles = Profile::where(
                'workspace_id',
                $payload['workspace_id']
            )->get();

            return $this->sendSuccess(
                'Profiles retrieved successfully',
                ProfileResource::collection($profiles)
            );
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function info(ProfileGetRequest $request)
    {
        try {
            $payload = $request->validated();
            $profile = $this->profileService->getInfo($payload['workspace_id']);

            return new ProfileResource($profile);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function updateInfo(ProfileGetRequest $request)
    {
        try {
            $payload = $request->validated();
            $profile = $this->profileService->getInfo($payload['workspace_id']);
            $profile = $this->profileService->updateOne($profile->id, $payload);

            return new ProfileResource($profile);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\GET(
     *     path="/api/profiles",
     *     tags={"Profiles"},
     *     summary="Get Profiles list",
     *     description="Get Profiles List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(Request $request)
    {
        try {
            $this->authorize('viewAny', Profile::class);

            $profiles = $this->profileService->paginate($request->all());
            return ProfileResource::collection($profiles);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\GET(
     *     path="/api/profiles/{id}",
     *     tags={"Profiles"},
     *     summary="Get Profile detail",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(Request $request, int $id)
    {
        try {
            // $this->authorize('view', Profile::class);

            $profile = $this->profileService->getOneOrFail($id, $request->all());
            return new ProfileResource($profile);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\PUT(
     *     path="/api/profiles/{id}",
     *     tags={"Profiles"},
     *     summary="Update an existing Profile",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function update(ProfileUpdateRequest $request, int $id)
    {
        try {
            $payload = $request->validated();

            $this->authorize('update', [Profile::class, $payload['workspace_id']]);

            $profile = $this->profileService->updateOne($id, $payload);

            return new ProfileResource($profile);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\DELETE(
     *     path="/api/profiles/{id}",
     *     tags={"Profiles"},
     *     summary="Delete a Profile",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy(Request $request, int $id)
    {
        try {
            $request->validate([
                'workspace_id' => 'required|exists:workspaces,id',
            ]);

            $this->authorize('delete', [Profile::class, $request->workspace_id]);

            $profile = $this->profileService->deleteOne($id);
            return new ProfileResource($profile);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
