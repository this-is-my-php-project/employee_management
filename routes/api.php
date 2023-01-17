<?php

use App\Modules\Auth\AuthController;
use App\Modules\Role\RoleController;
use App\Modules\User\UserController;
use Illuminate\Support\Facades\Route;
use App\Modules\Permission\PermissionController;
use App\Modules\Project\ProjectController;
use App\Modules\Workspace\WorkspaceController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    // Users
    Route::resource('users', UserController::class);
    Route::put('users/{id}/roles', [UserController::class, 'updateUserRoles']);

    // Roles
    Route::resource('roles', RoleController::class);

    // Permissions
    Route::resource('permissions', PermissionController::class);

    // workspaces
    Route::resource('workspaces', WorkspaceController::class);

    // Projects
    Route::resource('projects', ProjectController::class);
});
