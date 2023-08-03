<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;
use Laravel\Sanctum\PersonalAccessToken;
use App\Http\Requests\LoginMobileRequest;
use App\Http\Requests\LogoutMobileRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AuthController extends Controller
{
    const EXIT_TIME = 30;

    /**
     * Авторизация пользователя в системе.
     *
     * @OA\Post(
     *      path="/api/login",
     *      summary="Авторизация пользователя",
     *      description="Для авторизации нужен email и пароль пользователя",
     *      operationId="authLogin",
     *      tags={"Авторизация"},
     *      @OA\RequestBody(
     *          required=true,
     *          description="Значения общих настроек",
     *          @OA\JsonContent(
     *              @OA\Property(property="email", description="Email", type="string", example="admin@admin.ru"),
     *              @OA\Property(property="password", description="Пароль", type="string", example="password123")
     *          ),
     *      ),
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
     * @param  LoginRequest  $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        if (!Auth::attempt($request->validated())) {
            return response()->json([
                'error' => [
                    'error_code' => 2,
                    'error_msg' => __('auth.invalid_credentials'),
                ],
            ], 401);
        }

        return $this->createToken();
    }

    /**
     *
     * Авторизация пользователя в мобильном приложении.
     *
     * @OA\Post(
     *      path="/api/login-mobile",
     *      summary="Авторизация пользователя в мобильном приложении",
     *      description="Для авторизации нужен Registration ID, email и пароль пользователя",
     *      operationId="authLoginMobile",
     *      tags={"Авторизация"},
     *      @OA\RequestBody(
     *          required=true,
     *          description="Значения для авторизации",
     *          @OA\JsonContent(
     *              @OA\Property(property="registration_id", description="Registration ID", type="string", example="registration id"),
     *              @OA\Property(property="email", description="Email", type="string", example="admin@admin.ru"),
     *              @OA\Property(property="password", description="Пароль", type="string", example="password123")
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Авторизация прошла успешно",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(property="token", type="string", example="api mobile token"),
     *                  @OA\Property(property="user", type="object", example={"id":"1", "name":"ФИО"})
     *              )
     *          )
     *      ),
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
     * @param  LoginMobileRequest  $request
     * @return JsonResponse
     */
    public function loginMobile(LoginMobileRequest $request): JsonResponse
    {
        $validationData = $request->validated();
        if (!Auth::attempt([
            'email' => $validationData['email'],
            'password' => $validationData['password']
        ])) {
            return response()->json([
                'error' => [
                    'error_code' => 2,
                    'error_msg' => __('auth.invalid_credentials'),
                ],
            ], 401);
        }

        /** @var User $user */
        $user = auth()->user();
        if ($user->active) {
            $user->mobileIds()->firstOrCreate([
                'registration_id' => $validationData['registration_id']
            ]);
        }

        return $this->createToken(true);
    }

    /**
     * Регистрация пользователя в системе.
     *
     * @OA\Post(
     *      path="/api/register",
     *      summary="Регистрация пользователя",
     *      description="Для регистрации нужен email и пароль пользователя",
     *      operationId="authRegister",
     *      tags={"Авторизация"},
     *      @OA\RequestBody(
     *          required=true,
     *          description="Значения общих настроек",
     *          @OA\JsonContent(
     *              @OA\Property(property="name", description="Name", type="string", example="Admin"),
     *              @OA\Property(property="email", description="Email", type="string", example="admin@admin.ru"),
     *              @OA\Property(property="password", description="Пароль", type="string", example="password123"),
     *              @OA\Property(property="password_confirmation", description="Подтверждение пароля", type="string", example="password123")
     *          ),
     *      ),
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
     * @param  LoginRequest  $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create($request->validated());

        return response()->json([
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                ]
            ],
        ]);
    }

    /**
     * Создание токена для авторизованного пользователя.
     *
     * @param  bool  $isMobile
     * @return JsonResponse
     */
    public function createToken(bool $isMobile = false): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();

        if (!$isMobile) {
            $user->tokens()
                ->where('name', 'auth_token')
                ->where('last_used_at', '<', Carbon::now()->modify("-".self::EXIT_TIME." minutes"))
                ->delete();

            $newToken = $user->createToken('auth_token')->plainTextToken;
        } else {
            $newToken = $user->createToken('auth_token_mobile')->plainTextToken;
        }

        /** @var PersonalAccessToken $accessToken */
        $accessToken = $user->tokens()->where('name', 'accessToken')->first();
        if (empty($accessToken)) {
            $user->createToken('accessToken');
        }

        // $cookie = cookie('token', $newToken, 60 * 24); // 1 day

        if (!$isMobile) {
            return response()->json([
                'data' => [
                    'token' => $newToken,
                    'lifetime' => self::EXIT_TIME,
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'group' => $user->group->name,
                    ]
                ],
            ])->withHeaders([
                'Access-Control-Allow-Origin' => '*'
            ]);
        } else {
            return response()->json([
                'data' => [
                    'token' => $newToken,
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'group' => $user->group->name,
                    ]
                ],
            ]);
        }
    }

    /**
     *
     * Авторизация пользователя в мобильном приложении.
     *
     * @OA\Get(
     *      path="/api/logout",
     *      summary="Разлогинивание пользователя",
     *      description="Разлогинивает пользователя",
     *      operationId="authLogout",
     *      tags={"Авторизация"},
     *      security={ {"sanctum": {} }},
     *      @OA\Response(
     *          response=204,
     *          description="Разлогинивание прошло успешно",
     *      )
     * )
     *
     * @param  Request  $request
     */
    public function logout(Request $request)
    {
        $tokenAr = explode(" ", $request->header('Authorization'));
        $token = PersonalAccessToken::findToken($tokenAr[1]);
        $token->delete();
        $request->session()->invalidate();

        return response(null, ResponseAlias::HTTP_NO_CONTENT);
    }

    /**
     *
     * Авторизация пользователя в мобильном приложении.
     *
     * @OA\Post(
     *      path="/api/logout-mobile",
     *      summary="Разлогинивание пользователя в мобильном приложении",
     *      description="Удаляет Registration ID",
     *      operationId="authLogoutMobile",
     *      tags={"Авторизация"},
     *      security={ {"sanctum": {} }},
     *      @OA\RequestBody(
     *          required=true,
     *          description="Значения для разлогинивания",
     *          @OA\JsonContent(
     *              @OA\Property(property="registration_id", description="Registration ID", type="string", example="registration id")
     *          )
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Разлогинивание прошло успешно",
     *      )
     * )
     *
     * @param  LogoutMobileRequest  $request
     * @return Application|ResponseFactory|Response
     */
    public function logoutMobile(LogoutMobileRequest $request): Application|ResponseFactory|Response
    {
        $token = PersonalAccessToken::findToken($request->bearerToken());
        $token->delete();

        return response(null, ResponseAlias::HTTP_NO_CONTENT);
    }

    /**
     * Проверка пользователя по токену.
     *
     * @OA\Post(
     *      path="/api/verify-auth",
     *      summary="Проверка пользователя по токену",
     *      description="Проверка пользователя по токену",
     *      operationId="verifyAuth",
     *      tags={"Авторизация"},
     *      security={ {"sanctum": {} }},
     *      @OA\RequestBody(
     *          required=true,
     *          description="Значения общих настроек",
     *          @OA\JsonContent(
     *              @OA\Property(property="api_token", description="api_token", type="string", example="api_token")
     *          ),
     *      ),
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
     * @return JsonResponse
     */
    public function verifyAuth(Request $request): JsonResponse
    {
        $token = PersonalAccessToken::findToken($request->api_token);

        if (!$token) {
            return response()->json([
                'error' => [
                    'error_code' => 2,
                    'error_msg' => __('auth.invalid_credentials'),
                ],
            ], 401);
        }

        $user = User::findOrFail($token->tokenable_id);

        return response()->json([
            'data' => [
                'token' => $request->api_token,
                'lifetime' => self::EXIT_TIME,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'group' => $user->group->name,
                ]
            ],
        ])->withHeaders([
            'Access-Control-Allow-Origin' => '*'
        ]);
    }
}
