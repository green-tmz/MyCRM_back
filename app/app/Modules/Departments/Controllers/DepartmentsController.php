<?php

namespace App\Modules\Departments\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Departments\Models\Departments;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Modules\Departments\Requests\DepartmentsRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Modules\Departments\Resources\DepartmentsResource;
use App\Modules\Departments\Resources\DepartmentsListResource;

class DepartmentsController extends Controller
{
    /**
     * Список должностей.
     *
     * @OA\Get(
     *     path="/api/departments",
     *     operationId="getDepartmentsList",
     *     tags={"Список должностей"},
     *     summary="Список должностей",
     *     description="Получения списка всех должностей",
     *     security={{"sanctum": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Список должностей",
     *           @OA\JsonContent(
     *              @OA\Property(property="lang", type="string", example="ru"),
     *              @OA\Property(
     *                  property="departments",
     *                  type="array",
     *                  @OA\Items(
     *                      @OA\Property(property="id", type="integer", example="1"),
     *                      @OA\Property(property="name", type="string", example="Директор"),
     *                      @OA\Property(property="slug", type="string", example="director"),
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
        return DepartmentsListResource::collection(Departments::all());
    }

    /**
     * Создание новой должности.
     *
     * @OA\Post(
     *     path="/api/departments",
     *     operationId="departmentsStore",
     *     tags={"Создание новой должности"},
     *     summary="Создание новой должности",
     *     description="Сохраняет новую должность и возвращает ее данные",
     *     security={ {"sanctum": {} }},
     *     @OA\RequestBody(
     *          required=true,
     *          description="Значения общих настроек",
     *          @OA\JsonContent(
     *              @OA\Property(property="name", description="Name", type="string", example="Должность"),
     *              @OA\Property(property="slug", description="Slug", type="string", example="new-department")
     *          ),
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Ответ с id должности",
     *         @OA\JsonContent(
     *              @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example="1"),
     *                 @OA\Property(property="name", type="string", example="Должность"),
     *                 @OA\Property(property="slug", type="string", example="department")
     *              )
     *         )
     *     )
     * )
     *
     * @param DepartmentsRequest $request
     * @return DepartmentsListResource
     */
    public function store(DepartmentsRequest $request): JsonResource
    {
        try {
            Departments::create($request->validated());

            return DepartmentsListResource::collection(Departments::all());
        } catch (\Throwable $th) {
            throw new HttpResponseException(
                response()->json([
                    'error' => [
                        "error_code" => 10,
                        "error_msg" => 'Ошибка создания должности',
                    ]
                ], 422));
        }
    }

    /**
     * Редактирование должности.
     *
     * @OA\Put(
     *     path="/api/departments/{department}",
     *     operationId="departmentUpdate",
     *     tags={"Редактирование должности"},
     *     summary="Редактирование должности",
     *     description="Редактирует должность и возвращает ее данные",
     *     security={ {"sanctum": {} }},
     *     @OA\Parameter(
     *         description="id должности",
     *         in="path",
     *         name="department",
     *         required=true,
     *         example="1"
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          description="Значения общих настроек",
     *          @OA\JsonContent(
     *              @OA\Property(property="name", description="Name", type="string", example="Новая должность"),
     *              @OA\Property(property="slug", description="Slug", type="string", example="new-department")
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
     *                 @OA\Property(property="name", type="string", example="Новая должность"),
     *                 @OA\Property(property="slug", type="string", example="new-department")
     *              )
     *         )
     *     )
     * )
     *
     * @param DepartmentsRequest $request
     * @return DepartmentsResource
     */
    public function update(DepartmentsRequest $request, Departments $department): DepartmentsResource
    {
        $department->update($request->validated());

        return new DepartmentsResource($department);
    }

    /**
     * Удаление должности.
     *
     * @OA\Delete(
     *     path="/api/departments/{department}",
     *     operationId="departmentsDestroy",
     *     tags={"Удаление должности"},
     *     summary="Удаление должности",
     *     description="Удаляет должность",
     *     security={ {"sanctum": {} }},
     *     @OA\Parameter(
     *         description="id должности",
     *         in="path",
     *         name="department",
     *         required=true,
     *         example="1"
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Удаление должности прошло успешно",
     *     )
     * )
     *
     * @param  Departments  $department
     * @return JsonResource
     */
    public function destroy(Departments $department): JsonResource
    {
        // /** @var User $user */
        // foreach($department->user as $user) {
        //     $user->group_id = null;
        //     $user->save();
        // }
        $department->delete();

        return $this->index();
    }
}
