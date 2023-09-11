<?php

namespace App\Modules\Personal\Routes;

use App\Modules\Personal\Controllers\PersonalController;
use Illuminate\Support\Facades\Route;

class PersonalRoutes
{
    public static function api()
    {
        Route::resource('personals', PersonalController::class);
    }
}
