<?php

namespace App\Modules\Groups\Routes;

use App\Modules\Groups\Controllers\GroupController;
use Illuminate\Support\Facades\Route;

class GroupsRoutes
{
    public static function api()
    {
        Route::resource('groups', GroupController::class);
    }
}
