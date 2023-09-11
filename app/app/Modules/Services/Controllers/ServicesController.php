<?php

namespace App\Modules\Services\Controllers;

use OpenApi\Annotations as OA;
use App\Modules\Services\Models\Service;
use App\Modules\Services\Controllers\Controller;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Modules\Services\Requests\ServiceRequest;
use App\Modules\Services\Resources\ServiceResource;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Modules\Services\Resources\ServiceFormResource;
use App\Modules\Services\Resources\ServicesListResource;

class ServicesController extends Controller
{
    /**
     * Список услуг.
     *
     * @OA\Get(
     *     path="/api/services",
     *     operationId="getServicesList",
     *     tags={"Список услуг"},
     *     summary="Список услуг",
     *     description="Получения списка всех услуг",
     *     security={{"sanctum": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Список услуг",
     *           @OA\JsonContent(
     *              @OA\Property(property="lang", type="string", example="ru"),
     *              @OA\Property(
     *                  property="services",
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
        return ServicesListResource::collection(Service::all());
    }

    /**
     * Создание новой услуги.
     *
     * @OA\Post(
     *     path="/api/services",
     *     operationId="serviceStore",
     *     tags={"Создание новой услуги"},
     *     summary="Создание новой услуги",
     *     description="Сохраняет новую услугу и возвращает ее данные",
     *     security={ {"sanctum": {} }},
     *     @OA\RequestBody(
     *          required=true,
     *          description="Значения общих настроек",
     *          @OA\JsonContent(
     *              @OA\Property(property="name", description="Name", type="string", example="Новая услуга"),
     *              @OA\Property(property="slug", description="Slug", type="string", example="new-service"),
     *              @OA\Property(property="desc", description="Desc", type="string", example="Описание новой услуги"),
     *              @OA\Property(property="duration", description="Duration", type="timestamp", example="00:30:00"),
     *              @OA\Property(property="active", description="Active", type="boolean", example="true")
     *          ),
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Ответ с id услуги",
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
     * @param ServiceRequest $request
     * @return ServiceListResource
     */
    public function store(ServiceRequest $request): JsonResource
    {
        try {
            Service::create($request->validated());

            return ServicesListResource::collection(Service::all());
        } catch (\Throwable $th) {
            throw new HttpResponseException(
                response()->json([
                    'error' => [
                        "error_code" => 10,
                        "error_msg" => 'Ошибка создания услуги',
                    ]
                ], 422));
        }
    }

    /**
     * Получение информации об услуге.
     *
     * @OA\Get(
     *     path="/api/services/{service}",
     *     operationId="serviceShow",
     *     tags={"Детальная услуги"},
     *     summary="Информация о услуге",
     *     description="Выводит информацию об услуге",
     *     security={ {"sanctum": {} }},
     *     @OA\Parameter(
     *         description="id услуги",
     *         in="path",
     *         name="service",
     *         required=true,
     *         example="1"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Информация об услуге",
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
     * @param  Service  $service
     * @return ServiceResource
     */
    public function show(Service $service): ServiceResource
    {
        return new ServiceResource($service);
    }

    /**
     * Редактирование услуги.
     *
     * @OA\Put(
     *     path="/api/services/{service}",
     *     operationId="serviceUpdate",
     *     tags={"Редактирование услуги"},
     *     summary="Редактирование услуги",
     *     description="Редактирует услугу и возвращает ее данные",
     *     security={ {"sanctum": {} }},
     *     @OA\Parameter(
     *         description="id услуги",
     *         in="path",
     *         name="service",
     *         required=true,
     *         example="1"
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          description="Значения общих настроек",
     *          @OA\JsonContent(
     *              @OA\Property(property="name", description="Name", type="string", example="Новая услуга"),
     *              @OA\Property(property="slug", description="Slug", type="string", example="new-service"),
     *              @OA\Property(property="desc", description="Desc", type="string", example="Описание новой услуги"),
     *              @OA\Property(property="duration", description="Duration", type="timestamp", example="00:30:00"),
     *              @OA\Property(property="active", description="Active", type="boolean", example="true")
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
     * @param ServiceRequest $request
     * @return ServiceResource
     */
    public function update(ServiceRequest $request, Service $service): ServiceResource
    {
        $service->update($request->validated());

        return new ServiceResource($service);
    }

    /**
     * Удаление услуги.
     *
     * @OA\Delete(
     *     path="/api/services/{service}",
     *     operationId="serviceDestroy",
     *     tags={"Удаление услуги"},
     *     summary="Удаление услуги",
     *     description="Удаляет услуги",
     *     security={ {"sanctum": {} }},
     *     @OA\Parameter(
     *         description="id услуги",
     *         in="path",
     *         name="service",
     *         required=true,
     *         example="1"
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Удаление услуги прошло успешно",
     *     )
     * )
     *
     * @param  Service  $services
     * @return JsonResource
     */
    public function destroy(Service $service): JsonResource
    {
        $service->delete();

        return $this->index();
    }
}
