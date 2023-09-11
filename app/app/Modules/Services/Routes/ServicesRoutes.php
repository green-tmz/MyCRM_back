<?php

namespace App\Modules\Services\Routes;

use App\Modules\Services\Controllers\ServicesController;
use Illuminate\Support\Facades\Route;

class ServicesRoutes
{
    public static function api()
    {
        Route::resource('services', ServicesController::class);
    }
}
