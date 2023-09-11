<?php

namespace App\Modules\Roles\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RolesFormResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $fields = [
            [
                'name' => 'name',
                'type' => 'string'
            ],
            [
                'name' => 'slug',
                'type' => 'string'
            ],
        ];

        return compact('fields');
    }
}
