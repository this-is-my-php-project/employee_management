<?php

use App\Modules\AttendanceRecord\AttendanceRecordController;
use App\Modules\Auth\AuthController;
use App\Modules\Department\DepartmentController;
use App\Modules\EmployeeType\EmployeeTypeController;
use App\Modules\InvitationUrl\InvitationUrlController;
use App\Modules\JobDetail\JobDetailController;
use App\Modules\Role\RoleController;
use App\Modules\User\UserController;
use Illuminate\Support\Facades\Route;
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
    Route::post('logout', [AuthController::class, 'logout']);

    Route::middleware('is_super_admin')->group(function () {
        Route::prefix('admin')->group(function () {
            // Users
            Route::get('users', [UserController::class, 'index']);
            Route::get('users/{id}', [UserController::class, 'show']);
            Route::put('users/{id}', [UserController::class, 'update']);
            Route::delete('users/{id}', [UserController::class, 'destroy']);

            // Workspaces
            Route::get('workspaces', [WorkspaceController::class, 'index']);
            Route::get('workspaces/{id}', [WorkspaceController::class, 'show']);
            Route::post('workspaces', [WorkspaceController::class, 'store']);
            Route::put('workspaces/{id}', [WorkspaceController::class, 'update']);
            Route::delete('workspaces/{id}', [WorkspaceController::class, 'destroy']);

            // invitations Url
            Route::get('invitations', [InvitationUrlController::class, 'index']);
            Route::get('invitations/{id}', [InvitationUrlController::class, 'show']);
            Route::post('generate-url', [InvitationUrlController::class, 'generateUrl'])->name('invitations');

            // Departments
            Route::get('departments', [DepartmentController::class, 'index']);
            Route::get('departments/{id}', [DepartmentController::class, 'show']);
            Route::post('departments', [DepartmentController::class, 'store']);
            Route::put('departments/{id}', [DepartmentController::class, 'update']);
            Route::delete('departments/{id}', [DepartmentController::class, 'destroy']);

            // Job Details
            Route::get('job-details', [JobDetailController::class, 'index']);
            Route::get('job-details/{id}', [JobDetailController::class, 'show']);
            Route::post('job-details', [JobDetailController::class, 'store']);
            Route::put('job-details/{id}', [JobDetailController::class, 'update']);
            Route::delete('job-details/{id}', [JobDetailController::class, 'destroy']);

            // Profiles
            Route::get('profiles', [ProfileController::class, 'index']);
            Route::get('profiles/{id}', [ProfileController::class, 'show']);
            Route::post('profiles', [ProfileController::class, 'store']);
            Route::put('profiles/{id}', [ProfileController::class, 'update']);
            Route::delete('profiles/{id}', [ProfileController::class, 'destroy']);

            // Shifts
            Route::get('shifts', [ShiftController::class, 'index']);
            Route::get('shifts/{id}', [ShiftController::class, 'show']);
            Route::post('shifts', [ShiftController::class, 'store']);
            Route::put('shifts/{id}', [ShiftController::class, 'update']);
            Route::delete('shifts/{id}', [ShiftController::class, 'destroy']);

            // Attendance Records
            Route::get('attendance-records', [AttendanceRecordController::class, 'index']);
            Route::get('attendance-records/{id}', [AttendanceRecordController::class, 'show']);
            Route::post('attendance-records', [AttendanceRecordController::class, 'store']);
            Route::put('attendance-records/{id}', [AttendanceRecordController::class, 'update']);
            Route::delete('attendance-records/{id}', [AttendanceRecordController::class, 'destroy']);
        });
    });


    Route::prefix('user')->group(function () {
        // Users
        Route::get('user-self-info', [UserController::class, 'getSelfInfo']);
        Route::put('user-update-self-info', [UserController::class, 'updateSelfInfo']);

        // Workspaces
        Route::get('workspaces', [WorkspaceController::class, 'myWorkspaces']);
        Route::post('workspaces', [WorkspaceController::class, 'store']);
        Route::put('workspaces/{id}', [WorkspaceController::class, 'update']);
        Route::delete('workspaces/{id}', [WorkspaceController::class, 'destroy']);
        Route::post('add-to-workspace', [WorkspaceController::class, 'addToWorkspace'])->name('add-to-workspace');

        // invitations Url
        Route::post('generate-url', [InvitationUrlController::class, 'generateUrl'])->name('invitations');
        Route::get('invitation-url', [InvitationUrlController::class, 'getInvitationUrl']);
        Route::put('reset-invitation-url', [InvitationUrlController::class, 'resetInvitationUrl']);

        // Departments
        Route::get('departments', [DepartmentController::class, 'getDepartments']);
        Route::post('departments', [DepartmentController::class, 'store']);
        Route::post('move-user-department', [DepartmentController::class, 'moveUser']);

        // Job Details
        Route::get('job-details', [JobDetailController::class, 'getJobDetails']);

        // Profiles
        Route::get('profiles', [ProfileController::class, 'getProfiles']);
        Route::get('profiles/{id}', [ProfileController::class, 'show']);
        Route::put('profiles-update-info', [ProfileController::class, 'getProfiles']);
        Route::delete('profiles/{id}', [ProfileController::class, 'destroy']);
        Route::get('profile-self-info', [ProfileController::class, 'info']);
        Route::put('profile-update-self-info', [ProfileController::class, 'updateInfo']);

        // Shifts
        Route::get('shifts', [ShiftController::class, 'getShifts']);
        Route::post('assign-shift', [ShiftController::class, 'assignUser']);
        Route::post('shifts', [ShiftController::class, 'store']);

        // Attendance Records
        Route::get('attendance-records', [AttendanceRecordController::class, 'getAttendanceRecords']);
        Route::get('attendance-record-info', [AttendanceRecordController::class, 'getAttendanceRecordInfo']);
        Route::post('attendance-records', [AttendanceRecordController::class, 'store']);
    });

    Route::prefix('public')->group(function () {
        // Roles
        Route::get('roles', [RoleController::class, 'index']);
        Route::get('roles/{id}', [RoleController::class, 'show']);

        // Employees Types
        Route::get('employee-types', [EmployeeTypeController::class, 'index']);
        Route::get('employee-types/{id}', [EmployeeTypeController::class, 'show']);
    });
});
