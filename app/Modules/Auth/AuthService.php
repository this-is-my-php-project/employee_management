<?php

namespace App\Modules\Auth;

use App\Modules\Role\Role;
use App\Modules\User\User;
use App\Modules\User\UserService;
use Illuminate\Support\Facades\DB;
use App\Libraries\Crud\BaseService;
use Illuminate\Support\Facades\Hash;
use App\Modules\Role\Constants\RoleConstants;
use App\Modules\User\UserRepository;

class AuthService extends BaseService
{
    protected array $allowedRelations = [];

    protected UserRepository $userRepository;

    public function __construct(
        AuthRepository $repo,
        UserRepository $userRepository
    ) {
        parent::__construct($repo);
        $this->userRepository = $userRepository;
    }

    public function login(array $payload)
    {
        $email = $payload['email'];
        $password = $payload['password'];
        $user = User::where('email', $email)->first();

        if (!$user) {
            return abort(401, 'Invalid credentials');
        }

        if (!Hash::check($password, $user->password)) {
            return abort(401, 'Invalid credentials');
        }

        $token['token'] = $user->createToken('token')->accessToken;
        $token['user'] = $user;

        return $token;
    }

    /**
     * user registration
     * 
     * @param array $payload
     * @return User|null
     */
    public function createOne(array $payload): ?User
    {
        return DB::transaction(function () use ($payload) {
            $payload['password'] = bcrypt($payload['password']);
            $payload['name'] = strtolower(trim($payload['name']));
            $user = $this->userRepository->createOne([
                'name' => $payload['name'],
                'email' => $payload['email'],
                'password' => $payload['password'],
                'created_by' => 1,
            ]);

            return $user;
        });
    }

    /**
     * get authenticated user
     * 
     * @return User
     */
    public static function getAuthUser(): User
    {
        return auth()->user();
    }
}
