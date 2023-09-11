<?php

namespace App\Modules\Organizations\Controllers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Modules\Organizations\Models\Organizations;
use App\Modules\Organizations\Controllers\Controller;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Modules\Organizations\Requests\OrganizationsRequest;
use App\Modules\Organizations\Resources\OrganizationsListResource;

class OrganizationController extends Controller
{
    /**
     * Список основных настроек.
     *
     * @OA\Get(
     *     path="/api/organizations",
     *     operationId="getOrganizationsList",
     *     tags={"Список основных настроек"},
     *     summary="Список основных настроек.",
     *     description="Получения списка всех основных настроек",
     *     security={{"sanctum": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Список основных настроек",
     *           @OA\JsonContent(
     *              @OA\Property(property="lang", type="string", example="ru"),
     *              @OA\Property(
     *                  property="users",
     *                  type="array",
     *                  @OA\Items(
     *
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
        return OrganizationsListResource::collection(Organizations::all());
    }

    /**
     * Создание настройки.
     *
     * @OA\Post(
     *     path="/api/organizations",
     *     operationId="organizationsStore",
     *     tags={"Создание настройки"},
     *     summary="Создание настройки",
     *     description="Сохраняет новую настройку и возвращает ее данные",
     *     security={ {"sanctum": {} }},
     *     @OA\RequestBody(
     *          description="Значения общих настроек",
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  @OA\Property(property="name", description="name", type="string", example="Моя организация"),
     *                  @OA\Property(property="form", description="form", type="integer", example="1"),
     *                  @OA\Property(property="director", description="director", type="string", example="Иванов И.И."),
     *                  @OA\Property(property="start_at", description="start_at", type="string", example="09:00:00"),
     *                  @OA\Property(property="end_at", description="end_at", type="string", example="18:00:00"),
     *                  @OA\Property(
     *                      property="days",
     *                      description="days",
     *                      type="enum",
     *                      example="['Пн', 'Вт']"
     *                  ),
     *                  @OA\Property(
     *                      property="logo",
     *                      description="logo",
     *                      type="array",
     *                      @OA\Items(type="string", format="binary"),
     *                  ),
     *              ),
     *          ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Ответ с id настройки",
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
     * @param OrganizationsRequest $request
     * @return OrganizationsListResource
     */
    public function store(OrganizationsRequest $request): JsonResource
    {
        try {
            Organizations::create($request->validated());

            return OrganizationsListResource::collection(Organizations::all());
        } catch (\Throwable $th) {
            throw new HttpResponseException(
                response()->json([
                    'error' => [
                        "error_code" => 10,
                        "error_msg" => 'Ошибка создания настройки',
                    ]
                ], 422));
        }
    }

    /**
     * Редактирование основных настроек.
     *
     * @OA\Put(
     *     path="/api/organizations/{organization}",
     *     operationId="organizationsUpdate",
     *     tags={"Редактирование основных настроек"},
     *     summary="Редактирование основных настроек",
     *     description="Редактирует основные настроеки и возвращает их",
     *     security={ {"sanctum": {} }},
     *     @OA\Parameter(
     *         description="id настройки",
     *         in="path",
     *         name="organization",
     *         required=true,
     *         example="1"
     *     ),
     *     @OA\RequestBody(
     *          description="Значения общих настроек",
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  @OA\Property(property="name", description="name", type="string", example="Моя организация"),
     *                  @OA\Property(property="form", description="form", type="integer", example="1"),
     *                  @OA\Property(property="director", description="director", type="string", example="Иванов И.И."),
     *                  @OA\Property(property="start_at", description="start_at", type="string", example="09:00:00"),
     *                  @OA\Property(property="end_at", description="end_at", type="string", example="18:00:00"),
     *                  @OA\Property(
     *                      property="days",
     *                      description="days",
     *                      type="enum",
     *                      example="['Пн', 'Вт']"
     *                  ),
     *                  @OA\Property(
     *                      property="logo",
     *                      description="logo",
     *                      type="array",
     *                      @OA\Items(type="string", format="binary"),
     *                  ),
     *              ),
     *          ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Ответ с id настройки",
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
     * @param OrganizationsRequest $request
     * @return OrganizationsListResource
     */
    public function update(OrganizationsRequest $request, Organizations $organization): OrganizationsListResource
    {
        $organization->update($request->validated());

        return new OrganizationsListResource($organization);
    }

    /**
     * Удаление основных настроек.
     *
     * @OA\Delete(
     *     path="/api/organizations/{organization}",
     *     operationId="organizationsDestroy",
     *     tags={"Удаление основных настроек"},
     *     summary="Удаление основных настроек",
     *     description="Удаление основных настроек",
     *     security={ {"sanctum": {} }},
     *     @OA\Parameter(
     *         description="id настройки",
     *         in="path",
     *         name="organization",
     *         required=true,
     *         example="1"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Список настроек",
     *         @OA\JsonContent(
     *         )
     *     )
     * )
     *
     * @param  Organizations  $organization
     */
    public function destroy(Organizations $organization)
    {
        $organization->delete();

        return $this->index();
    }
}
