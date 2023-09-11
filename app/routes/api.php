<?php

use App\Modules\Users\Routes\UsersRoutes;
use App\Http\Controllers\Controller;
use App\Modules\Roles\Routes\RolesRoutes;
use App\Modules\Services\Routes\ServicesRoutes;
use App\Modules\Organizations\Routes\OrganizationRoutes;
use App\Modules\Departments\Routes\DepartmentsRoutes;
use App\Modules\Personal\Routes\PersonalRoutes;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login');
    Route::post('/register', 'register');
    Route::post('/login-mobile', 'loginMobile');
    Route::post('/verify-auth', 'verifyAuth');
});

Route::get('version', [Controller::class, 'getAppVersion']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::post('/logout-mobile', [AuthController::class, 'logoutMobile']);
    Route::get('/main-menu', [Controller::class, 'mainMenu']);

    UsersRoutes::api();
    RolesRoutes::api();
    ServicesRoutes::api();
    OrganizationRoutes::api();
    DepartmentsRoutes::api();
    PersonalRoutes::api();
});
