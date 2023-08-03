<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use OpenApi\Annotations as OA;

/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         title="Авторизация/Базовые методы",
 *         version="1.0.0",
 *     )
 * )
 *
 * Class Controller
 * @package App\Http\Controllers
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * @OA\Get(
     *      path="/api/version",
     *      summary="Версия api приложения",
     *      description="Возвращает текущую версию api приложения",
     *      operationId="version",
     *      tags={"Версия api"},
     *      @OA\Response(
     *          response=200,
     *          description="Версия api приложения",
     *      )
     * )
     *
     * @return mixed
     */
    public function getAppVersion()
    {
        return env('APP_FRONTEND_VERSION');
    }
}
