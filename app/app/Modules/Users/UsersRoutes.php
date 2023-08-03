<?php

namespace App\Modules\Users;

use App\Modules\Users\Controllers\UserController;
use Illuminate\Support\Facades\Route;

class UsersRoutes
{
    public static function api()
    {
        Route::resource('users', UserController::class);
    }
}
