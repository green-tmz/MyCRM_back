<?php

namespace App\Modules\Roles\Routes;

use Illuminate\Support\Facades\Route;
use App\Modules\Roles\Controllers\RolesController;

class RolesRoutes
{
    public static function api()
    {
        Route::resource('roles', RolesController::class);
    }
}
