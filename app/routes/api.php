<?php

use App\Modules\Users\Routes\UsersRoutes;
use App\Http\Controllers\Controller;
use App\Modules\Groups\Routes\GroupsRoutes;
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
    GroupsRoutes::api();
});
