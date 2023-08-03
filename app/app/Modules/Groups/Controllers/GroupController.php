<?php

namespace App\Modules\Groups\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
use Illuminate\Http\JsonResponse;
use App\Modules\Groups\Models\Group;
use App\Modules\Groups\Requests\GroupRequest;
use App\Modules\Groups\Controllers\Controller;
use App\Modules\Groups\Resources\GroupResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Modules\Groups\Resources\GroupFormResource;
use App\Modules\Groups\Resources\GroupListResource;
use Illuminate\Http\Exceptions\HttpResponseException;

class GroupController extends Controller
{
    /**
     * Список групп.
     *
     * @OA\Get(
     *     path="/api/groups",
     *     operationId="getGroupsList",
     *     tags={"Список групп"},
     *     summary="Список групп",
     *     description="Получения списка всех групп",
     *     security={{"sanctum": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Список групп",
     *           @OA\JsonContent(
     *              @OA\Property(property="lang", type="string", example="ru"),
     *              @OA\Property(
     *                  property="users",
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
        return GroupListResource::collection(Group::all());
    }

    /**
     * Поля для создания группы.
     *
     * @OA\Get(
     *     path="/api/groups/create",
     *     operationId="createGroup",
     *     tags={"Поля для создания группы"},
     *     summary="Список групп",
     *     description="Получения списка полей для создания группы",
     *     security={{"sanctum": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Поля для создания группы",
     *           @OA\JsonContent(
     *              @OA\Property(property="lang", type="string", example="ru"),
     *              @OA\Property(
     *                  property="groups",
     *                  type="array",
     *                  @OA\Items(
     *                      @OA\Property(property="name", type="string", example="Группа"),
     *                      @OA\Property(property="slug", type="string", example="group"),
     *                  )
     *              )
     *         )
     *     )
     * )
     *
     */
    public function create(): GroupFormResource
    {
        return new GroupFormResource(new Group());
    }

    /**
     * Создание новой группы.
     *
     * @OA\Post(
     *     path="/api/groups",
     *     operationId="groupStore",
     *     tags={"Создание новой группы"},
     *     summary="Создание новой группы",
     *     description="Сохраняет новую группу и возвращает ее данные",
     *     security={ {"sanctum": {} }},
     *     @OA\RequestBody(
     *          required=true,
     *          description="Значения общих настроек",
     *          @OA\JsonContent(
     *              @OA\Property(property="name", description="Name", type="string", example="Новая группа"),
     *              @OA\Property(property="slug", description="Slug", type="string", example="new-group")
     *          ),
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Ответ с id группы",
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
     * @param GroupRequest $request
     * @return GroupResource
     */
    public function store(GroupRequest $request): GroupResource
    {
        try {
            return new GroupResource(
                Group::create($request->validated())
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
     * Получение информации о группе.
     *
     * @OA\Get(
     *     path="/api/groups/{group}",
     *     operationId="groupShow",
     *     tags={"Детальная группы"},
     *     summary="Информация о группе",
     *     description="Выводит информацию о группе",
     *     security={ {"sanctum": {} }},
     *     @OA\Parameter(
     *         description="id группы",
     *         in="path",
     *         name="group",
     *         required=true,
     *         example="1"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Информация о группе",
     *           @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(property="id", type="integer", example="1"),
     *                  @OA\Property(property="name", type="string", example="Новая группа"),
     *                  @OA\Property(property="slug", type="string", example="new-group")
     *              )
     *         )
     *     )
     * )
     *
     * @param  Group  $group
     * @return GroupResource
     */
    public function show(Group $group): GroupResource
    {
        return new GroupResource($group);
    }

    /**
     * Редактирование группы.
     *
     * @OA\Put(
     *     path="/api/groups/{group}",
     *     operationId="groupUpdate",
     *     tags={"Редактирование группы"},
     *     summary="Редактирование группы",
     *     description="Редактирует группу и возвращает ее данные",
     *     security={ {"sanctum": {} }},
     *     @OA\Parameter(
     *         description="id группы",
     *         in="path",
     *         name="group",
     *         required=true,
     *         example="1"
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          description="Значения общих настроек",
     *          @OA\JsonContent(
     *              @OA\Property(property="name", description="Name", type="string", example="Новая группа"),
     *              @OA\Property(property="slug", description="Slug", type="string", example="new-group")
     *          ),
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Ответ с id группы",
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
     * @param GroupRequest $request
     * @return GroupResource
     */
    public function update(GroupRequest $request, Group $group): GroupResource
    {
        $group->update($request->validated());

        return new GroupResource($group);
    }

    /**
     * Удаление группы.
     *
     * @OA\Delete(
     *     path="/api/groups/{group}",
     *     operationId="groupDestroy",
     *     tags={"Удаление группы"},
     *     summary="Удаление группы",
     *     description="Удаляет группу",
     *     security={ {"sanctum": {} }},
     *     @OA\Parameter(
     *         description="id группы",
     *         in="path",
     *         name="group",
     *         required=true,
     *         example="1"
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Удаление группы прошло успешно",
     *     )
     * )
     *
     * @param  Group  $group
     * @return JsonResource
     */
    public function destroy(Group $group): JsonResource
    {
        /** @var User $user */
        foreach($group->user as $user) {
            $user->group_id = null;
            $user->save();
        }
        $group->delete();

        return $this->index();
    }
}
