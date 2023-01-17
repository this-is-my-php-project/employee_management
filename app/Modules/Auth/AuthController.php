<?php

namespace App\Modules\Auth;

use App\Http\Controllers\Controller;
use App\Modules\Auth\AuthService;
use App\Modules\Auth\Requests\AuthLoginRequest;
use App\Modules\Auth\Resources\AuthResource;
use App\Modules\Auth\Requests\AuthStoreRequest;
use App\Modules\User\User;
use App\Modules\User\UserService;

class AuthController extends Controller
{
    protected $authService;
    protected UserService $userService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @param AuthLoginRequest $request
     * 
     * @return AuthResource
     */
    public function login(AuthLoginRequest $request)
    {
        $payload = $request->validated();
        $user = $this->authService->login($payload);

        return new AuthResource($user);
    }

    /**
     * @param AuthStoreRequest $request
     * 
     * @return AuthResource
     */
    public function register(AuthStoreRequest $request)
    {
        $payload = $request->validated();
        $user = $this->authService->register($payload);
        $user = $this->authService->login($payload);

        return new AuthResource($user);
    }
}
