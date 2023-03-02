<?php

use App\Modules\Auth\AuthController;
use App\Modules\Department\DepartmentController;
use App\Modules\EmployeeType\EmployeeTypeController;
use App\Modules\InvitationUrl\InvitationUrlController;
use App\Modules\JobDetail\JobDetailController;
use App\Modules\Role\RoleController;
use App\Modules\User\UserController;
use Illuminate\Support\Facades\Route;
use App\Modules\Permission\PermissionController;
use App\Modules\Profile\ProfileController;
use App\Modules\Shift\ShiftController;
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
    Route::get('user-info', [UserController::class, 'getInfo']);
    Route::put('user-update-info', [UserController::class, 'updateInfo']);

    // Roles
    Route::resource('roles', RoleController::class);

    // Permissions
    Route::resource('permissions', PermissionController::class);

    // workspaces
    Route::resource('workspaces', WorkspaceController::class);
    Route::post('add-to-workspace', [WorkspaceController::class, 'addToWorkspace'])->name('add-to-workspace');
    Route::get('user-workspaces', [WorkspaceController::class, 'myWorkspaces']);

    // invitations Url
    Route::get('invitations', [InvitationUrlController::class, 'index']);
    Route::get('invitations/{id}', [InvitationUrlController::class, 'show']);
    Route::post('generate-url', [InvitationUrlController::class, 'generateUrl'])->name('invitations');
    Route::get('invitation-url', [InvitationUrlController::class, 'getInvitationUrl']);
    Route::put('/reset-invitation-url', [InvitationUrlController::class, 'resetInvitationUrl']);

    // employee types
    Route::resource('employee-types', EmployeeTypeController::class);

    // departments
    Route::resource('departments', DepartmentController::class);
    Route::post('move-user-department', [DepartmentController::class, 'moveUser']);

    // job details
    Route::resource('job-details', JobDetailController::class);

    // profile
    Route::resource('profiles', ProfileController::class);
    Route::put('disable-profile/{id}', [ProfileController::class, 'disableProfile']);
    Route::get('profile-info', [ProfileController::class, 'info']);
    Route::put('update-profile-info', [ProfileController::class, 'updateInfo']);
});
