<?php

namespace App\Modules\Organizations\Routes;

use App\Modules\Organization\Controllers\OrganizationController;
use Illuminate\Support\Facades\Route;

class OrganizationRoutes
{
    public static function api()
    {
        Route::resource('organizations', OrganizationController::class);
    }
}
