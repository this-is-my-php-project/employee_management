<?php

namespace App\Modules\User;

use App\Modules\User\User;
use App\Modules\User\UserService;
use App\Http\Controllers\Controller;
use App\Modules\User\Resources\UserResource;
use App\Modules\User\Requests\UserIndexRequest;
use App\Modules\User\Requests\UserStoreRequest;
use App\Modules\User\Requests\UserUpdateRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->middleware('auth');
        $this->userService = $userService;
    }

    public function getSelfInfo()
    {
        try {
            $this->authorize('info', User::class);

            $user = auth()->user();
            return new UserResource($user);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function updateSelfInfo(UserUpdateRequest $request)
    {
        try {
            $this->authorize('info', User::class);

            $payload = $request->validated();
            $user = $this->userService->updateOne(auth()->user()->id, $payload);

            return new UserResource($user);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\GET(
     *     path="/api/users",
     *     tags={"Users"},
     *     summary="Get Users list",
     *     description="Get Users List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(Request $request)
    {
        try {
            $this->authorize('viewAny', User::class);

            $payload = $request->all();
            $users = $this->userService->paginate($payload);

            return UserResource::collection($users);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\GET(
     *     path="/api/users/{id}",
     *     tags={"Users"},
     *     summary="Get User detail",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(UserIndexRequest $request, int $id)
    {
        try {
            $this->authorize('view', User::class);

            $payload = $request->validated();
            $user = $this->userService->getOne($id, $payload);

            return new UserResource($user);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\POST(
     *     path="/api/users",
     *     tags={"Users"},
     *     summary="Create a new User",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    // public function store(UserStoreRequest $request)
    // {
    //     try {
    //         $this->authorize('create', User::class);

    //         $payload = $request->validated();
    //         $user = $this->userService->createOne($payload);

    //         return new UserResource($user);
    //     } catch (\Exception $e) {
    //         return $this->sendError($e->getMessage());
    //     }
    // }

    /**
     * @OA\PUT(
     *     path="/api/users/{id}",
     *     tags={"Users"},
     *     summary="Update an existing User",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function update(UserUpdateRequest $request, int $id)
    {
        try {
            $this->authorize('update', User::class);

            $payload = $request->validate();
            $user = $this->userService->updateOne($id, $payload);

            return new UserResource($user);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\DELETE(
     *     path="/api/users/{id}",
     *     tags={"Users"},
     *     summary="Delete a User",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy(int $id)
    {
        try {
            $this->authorize('delete', User::class);

            $this->userService->deleteOne($id);
            return $this->sendSuccess('User deleted successfully');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\PUT(
     *     path="/api/users/{id}/roles",
     *     tags={"Users"},
     *     summary="Update an existing User's Roles",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function updateUserRoles(UserUpdateRequest $request, int $id)
    {
        try {
            $this->authorize('update', User::class);

            $payload = $request->all();
            $user = $this->userService->updateUserRoles($id, $payload);

            return new UserResource($user);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
