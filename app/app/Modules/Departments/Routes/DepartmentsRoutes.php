<?php

namespace App\Modules\Departments\Routes;

use App\Modules\Vacansies\Controllers\DepartmentsController;
use Illuminate\Support\Facades\Route;

class DepartmentsRoutes
{
    public static function api()
    {
        Route::resource('departments', DepartmentsController::class);
    }
}
