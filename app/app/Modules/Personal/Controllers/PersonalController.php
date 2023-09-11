<?php

namespace App\Modules\Personal\Controllers;

use App\Modules\Personal\Models\Personal;
use App\Modules\Personal\Controllers\Controller;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Modules\Personal\Resources\PersonalListResource;

class PersonalController extends Controller
{
    /**
     * Список сотрудников.
     *
     * @OA\Get(
     *     path="/api/personals",
     *     operationId="getPersonalsList",
     *     tags={"Список сотрудников"},
     *     summary="Список сотрудников",
     *     description="Получения списка всех сотрудников",
     *     security={{"sanctum": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Список сотрудников",
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
        return PersonalListResource::collection(Personal::all());
    }
}
