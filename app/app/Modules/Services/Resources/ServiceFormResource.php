<?php

namespace App\Modules\Services\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceFormResource extends JsonResource
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
            [
                'name' => 'desc',
                'type' => 'text'
            ],
            [
                'name' => 'duration',
                'type' => 'time'
            ],
            [
                'name' => 'active',
                'type' => 'boolean'
            ]
        ];

        return compact('fields');
    }
}
