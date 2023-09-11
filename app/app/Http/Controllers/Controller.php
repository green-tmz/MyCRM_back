<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

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

    /**
     * Получение основного меню пользователя.
     *
     * @OA\Get(
     *      path="/api/main-menu",
     *      summary="Основное меню пользователя",
     *      description="Получение основного меню пользователя",
     *      operationId="mainMenu",
     *      tags={"Основное меню"},
     *      security={ {"sanctum": {} }},
     *      @OA\Response(
     *          response=401,
     *          description="Неверные авторизационные данные",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="error",
     *                  type="object",
     *                  @OA\Property(property="error_code", type="integer", example="2"),
     *                  @OA\Property(property="error_msg", type="string", example="Неверные авторизационные данные.")
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Ошибка валидации",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="error",
     *                  type="object",
     *                  @OA\Property(property="error_code", type="integer", example="1"),
     *                  @OA\Property(property="error_msg", type="string", example="Ошибка валидации."),
     *                  @OA\Property(
     *                      property="fields",
     *                      type="object",
     *                      @OA\Property(property="email", type="array", @OA\Items(example="Поле email должно содержать корректный email.")),
     *                  )
     *              )
     *          )
     *      )
     * )
     *
     */
    public function mainMenu(Request $request)
    {
        $menu = [
            [
                "pages" => [
                    [
                        "heading" => __('sidebar.dashboard'),
                        "route" => "/dashboard",
                        "svgIcon" => "media/icons/duotune/art/art002.svg",
                        "fontIcon" => "bi-app-indicator"
                    ]
                ]
            ],
            [
                "pages" => [
                    [
                        "heading" => __('sidebar.calendar'),
                        "route" => "/apps/calendar",
                        "svgIcon" => "media/icons/duotune/art/art002.svg",
                        "fontIcon" => "ki-calendar-8"
                    ]
                ],
            ],
            [
                "heading" => __('sidebar.settings'),
                "pages" => [
                    [
                        "heading" => __('sidebar.settings.users'),
                        "route" => "/settings/users",
                        "svgIcon" => "media/icons/duotune/art/art002.svg",
                        "fontIcon" => "ki-calendar-8"
                    ],
                    [
                        "heading" => __('sidebar.settings.groups'),
                        "route" => "/settings/groups",
                        "svgIcon" => "media/icons/duotune/art/art002.svg",
                        "fontIcon" => "ki-calendar-8"
                    ],
                    [
                        "heading" => __('sidebar.settings.services'),
                        "route" => "/settings/services",
                        "svgIcon" => "media/icons/duotune/art/art002.svg",
                        "fontIcon" => "ki-calendar-8"
                    ]
                    // [
                    //     "sectionTitle" => __('sidebar.settings.users'),
                    //     "route" => "/profile",
                    //     "svgIcon" => "media/icons/duotune/general/gen022.svg",
                    //     "fontIcon" => "bi-archive",
                    //     "sub" => [
                    //         [
                    //             "heading" => "Users",
                    //             "route" => "/crafted/pages/profile/overview",
                    //         ]
                    //     ]
                    // ]
                ]
            ],
        ];

        return response()->json($menu);
    }


    /**
     * Возвращает токен пользователя из заголовка.
     *
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    protected function getTokenFromHeader(Request $request)
    {
        $authorizationArray = explode(" ", $request->header("authorization"));

        return $authorizationArray[1];
    }
}
