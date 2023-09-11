<?php

namespace App\Modules\Roles\Controllers;

use App\Models\User;
use OpenApi\Annotations as OA;
use App\Modules\Roles\Models\Roles;
use App\Modules\Roles\Requests\RolesRequest;
use App\Modules\Roles\Controllers\Controller;
use App\Modules\Roles\Resources\RolesResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Modules\Roles\Resources\RolesFormResource;
use App\Modules\Roles\Resources\RolesListResource;
use Illuminate\Http\Exceptions\HttpResponseException;

class RolesController extends Controller
{
    /**
     * Список ролей.
     *
     * @OA\Get(
     *     path="/api/roles",
     *     operationId="getRolesList",
     *     tags={"Список ролей"},
     *     summary="Список ролей",
     *     description="Получения списка всех ролей",
     *     security={{"sanctum": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Список ролей",
     *           @OA\JsonContent(
     *              @OA\Property(property="lang", type="string", example="ru"),
     *              @OA\Property(
     *                  property="roles",
     *                  type="array",
     *                  @OA\Items(
     *                      @OA\Property(property="id", type="integer", example="1"),
     *                      @OA\Property(property="name", type="string", example="Администраторы"),
     *                      @OA\Property(property="slug", type="string", example="admin"),
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
        return RolesListResource::collection(Roles::all());
    }

    /**
     * Создание новой роли.
     *
     * @OA\Post(
     *     path="/api/roles",
     *     operationId="rolesStore",
     *     tags={"Создание новой роли"},
     *     summary="Создание новой роли",
     *     description="Сохраняет новую роль и возвращает ее данные",
     *     security={ {"sanctum": {} }},
     *     @OA\RequestBody(
     *          required=true,
     *          description="Значения общих настроек",
     *          @OA\JsonContent(
     *              @OA\Property(property="name", description="Name", type="string", example="Новая роль"),
     *              @OA\Property(property="slug", description="Slug", type="string", example="new-role")
     *          ),
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Ответ с id роли",
     *         @OA\JsonContent(
     *              @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example="1"),
     *                 @OA\Property(property="name", type="string", example="Новая роль"),
     *                 @OA\Property(property="slug", type="string", example="new-role")
     *              )
     *         )
     *     )
     * )
     *
     * @param RolesRequest $request
     * @return RolesListResource
     */
    public function store(RolesRequest $request): JsonResource
    {
        try {
            Roles::create($request->validated());

            return RolesListResource::collection(Roles::all());
        } catch (\Throwable $th) {
            throw new HttpResponseException(
                response()->json([
                    'error' => [
                        "error_code" => 10,
                        "error_msg" => 'Ошибка создания роли',
                    ]
                ], 422));
        }
    }

    /**
     * Получение информации о роли.
     *
     * @OA\Get(
     *     path="/api/roles/{role}",
     *     operationId="roleShow",
     *     tags={"Детальная роли"},
     *     summary="Информация о роли",
     *     description="Выводит информацию о роли",
     *     security={ {"sanctum": {} }},
     *     @OA\Parameter(
     *         description="id роли",
     *         in="path",
     *         name="role",
     *         required=true,
     *         example="1"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Информация о роли",
     *           @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(property="id", type="integer", example="1"),
     *                  @OA\Property(property="name", type="string", example="Новая роль"),
     *                  @OA\Property(property="slug", type="string", example="new-role")
     *              )
     *         )
     *     )
     * )
     *
     * @param  Roles  $role
     * @return RolesResource
     */
    public function show(Roles $role): RolesResource
    {
        return new RolesResource($role);
    }

    /**
     * Редактирование роли.
     *
     * @OA\Put(
     *     path="/api/roles/{role}",
     *     operationId="roleUpdate",
     *     tags={"Редактирование роли"},
     *     summary="Редактирование роли",
     *     description="Редактирует роль и возвращает ее данные",
     *     security={ {"sanctum": {} }},
     *     @OA\Parameter(
     *         description="id группы",
     *         in="path",
     *         name="role",
     *         required=true,
     *         example="1"
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          description="Значения общих настроек",
     *          @OA\JsonContent(
     *              @OA\Property(property="name", description="Name", type="string", example="Новая роль"),
     *              @OA\Property(property="slug", description="Slug", type="string", example="new-role")
     *          ),
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Ответ с id роли",
     *         @OA\JsonContent(
     *              @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example="1"),
     *                 @OA\Property(property="name", type="string", example="Новая роль"),
     *                 @OA\Property(property="slug", type="string", example="new-role")
     *              )
     *         )
     *     )
     * )
     *
     * @param RolesRequest $request
     * @return RolesResource
     */
    public function update(RolesRequest $request, Roles $role): RolesResource
    {
        $role->update($request->validated());

        return new RolesResource($role);
    }

    /**
     * Удаление роли.
     *
     * @OA\Delete(
     *     path="/api/roles/{role}",
     *     operationId="roleDestroy",
     *     tags={"Удаление роли"},
     *     summary="Удаление роли",
     *     description="Удаляет роли",
     *     security={ {"sanctum": {} }},
     *     @OA\Parameter(
     *         description="id роли",
     *         in="path",
     *         name="role",
     *         required=true,
     *         example="1"
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Удаление роли прошло успешно",
     *     )
     * )
     *
     * @param  Roles  $role
     * @return JsonResource
     */
    public function destroy(Roles $role): JsonResource
    {
        $role->delete();

        return $this->index();
    }
}
