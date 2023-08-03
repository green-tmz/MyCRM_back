<?php

namespace App\Modules\Users\Controllers;


use App\Models\User;
use OpenApi\Annotations as OA;
use Illuminate\Http\JsonResponse;
use App\Modules\Users\Requests\UserRequest;
use App\Modules\Users\Controllers\Controller;
use App\Modules\Users\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Modules\Users\Resources\UserFormResource;
use App\Modules\Users\Resources\UserListResource;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserController extends Controller
{

    /**
     * Список пользователей.
     *
     * @OA\Get(
     *     path="/api/users",
     *     operationId="getEmployeesList",
     *     tags={"Список пользователей"},
     *     summary="Список пользователей",
     *     description="Получения списка всех пользователей",
     *     security={{"sanctum": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Список пользователей",
     *           @OA\JsonContent(
     *              @OA\Property(property="lang", type="string", example="ru"),
     *              @OA\Property(
     *                  property="users",
     *                  type="array",
     *                  @OA\Items(
     *                      @OA\Property(property="id", type="string", example="employee@test.ru"),
     *                      @OA\Property(property="name", type="string", example="Леонидов Леонид"),
     *                      @OA\Property(property="email", type="integer", example="employee@test.ru"),
     *                  )
     *              )
     *         )
     *     )
     * )
     *
     * @return JsonResource
     */
    public function index(): JsonResource
    {
        return UserListResource::collection(User::all());
    }

    /**
     * Поля для создания пользователя.
     *
     * @OA\Get(
     *     path="/api/users/create",
     *     operationId="createUser",
     *     tags={"Поля для создания пользователя"},
     *     summary="Список пользователей",
     *     description="Получения списка полей для создания пользователя",
     *     security={{"sanctum": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Поля для создания пользователя",
     *           @OA\JsonContent(
     *              @OA\Property(property="lang", type="string", example="ru"),
     *              @OA\Property(
     *                  property="users",
     *                  type="array",
     *                  @OA\Items(
     *                      @OA\Property(property="name", type="string", example="Леонидов Леонид"),
     *                      @OA\Property(property="email", type="integer", example="employee@test.ru"),
     *                      @OA\Property(property="password", type="string", example="password123"),
     *                  )
     *              )
     *         )
     *     )
     * )
     *
     */
    public function create(): UserFormResource
    {
        return new UserFormResource(new User());
    }

    /**
     * Создание нового пользователя.
     *
     * @OA\Post(
     *     path="/api/users",
     *     operationId="userStore",
     *     tags={"Создание нового пользователя"},
     *     summary="Создание нового пользователя",
     *     description="Сохраняет нового пользователя и возвращает его данные",
     *     security={ {"sanctum": {} }},
     *     @OA\RequestBody(
     *          required=true,
     *          description="Значения общих настроек",
     *          @OA\JsonContent(
     *              @OA\Property(property="name", description="Name", type="string", example="Новый пользователь"),
     *              @OA\Property(property="email", description="Email", type="string", example="user@site.ru"),
     *              @OA\Property(property="password", description="Пароль", type="string", example="password123"),
     *              @OA\Property(property="group_id", description="Группа", type="integer", example="1")
     *          ),
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Ответ с id пользователя",
     *         @OA\JsonContent(
     *              @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example="1"),
     *                 @OA\Property(property="name", type="string", example="Новый пользователь"),
     *                 @OA\Property(property="email", type="email", example="user@site.ru")
     *              )
     *         )
     *     )
     * )
     *
     * @param UserRequest $request
     * @return UserResource
     */
    public function store(UserRequest $request): UserResource
    {
        try {
            return new UserResource(
                User::create($request->validated())
            );
        } catch (\Throwable $th) {
            throw new HttpResponseException(
                response()->json([
                    'error' => [
                        "error_code" => 10,
                        "error_msg" => 'Ошибка создания пользователя',
                    ]
                ], 422));
        }
    }

    /**
     * Получение информации о пользователе.
     *
     * @OA\Get(
     *     path="/api/users/{user}",
     *     operationId="userShow",
     *     tags={"Детальная пользователя"},
     *     summary="Информация о пользователе",
     *     description="Выводит информацию о пользователе",
     *     security={ {"sanctum": {} }},
     *     @OA\Parameter(
     *         description="id пользователя",
     *         in="path",
     *         name="user",
     *         required=true,
     *         example="1"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Информация о пользователе",
     *           @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(property="id", type="integer", example="1"),
     *                  @OA\Property(property="name", type="string", example="Леонидов Леонид"),
     *                  @OA\Property(property="email", type="string", example="employee@test.ru"),
     *              )
     *         )
     *     )
     * )
     *
     * @param  User  $user
     * @return UserResource
     */
    public function show(User $user): UserResource
    {
        return new UserResource($user);
    }

    /**
     * Редактирование пользователя.
     *
     * @OA\Put(
     *     path="/api/users/{user}",
     *     operationId="userUpdate",
     *     tags={"Редактирование пользователя"},
     *     summary="Редактирование пользователя",
     *     description="Редактирует пользователя и возвращает его данные",
     *     security={ {"sanctum": {} }},
     *     @OA\Parameter(
     *         description="id пользователя",
     *         in="path",
     *         name="user",
     *         required=true,
     *         example="1"
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          description="Значения общих настроек",
     *          @OA\JsonContent(
     *              @OA\Property(property="name", description="Name", type="string", example="Новый пользователь"),
     *              @OA\Property(property="email", description="Email", type="string", example="user@site.ru"),
     *              @OA\Property(property="password", description="Пароль", type="string", example="password123"),
     *              @OA\Property(property="group_id", description="Группа", type="integer", example="1")
     *          ),
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Ответ с id пользователя",
     *         @OA\JsonContent(
     *              @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example="1"),
     *                 @OA\Property(property="name", type="string", example="Новая группа"),
     *                 @OA\Property(property="slug", type="string", example="new-group")
     *              )
     *         )
     *     )
     * )
     *
     * @param UserRequest $request
     * @return UserResource
     */
    public function update(UserRequest $request, User $user): UserResource
    {
        $user->update($request->validated());

        return new UserResource($user);
    }

    /**
     * Удаление пользователя.
     *
     * @OA\Delete(
     *     path="/api/users/{user}",
     *     operationId="userDestroy",
     *     tags={"Удаление пользователя"},
     *     summary="Удаление пользователя",
     *     description="Удаляет пользователя",
     *     security={ {"sanctum": {} }},
     *     @OA\Parameter(
     *         description="id пользователя",
     *         in="path",
     *         name="user",
     *         required=true,
     *         example="1"
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Удаление пользователя прошло успешно",
     *     )
     * )
     *
     * @param  User  $user
     * @return JsonResponse
     */
    public function destroy(User $user): JsonResource
    {
        $user->delete();

        return $this->index();
    }
}
