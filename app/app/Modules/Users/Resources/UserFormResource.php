<?php

namespace App\Modules\Users\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserFormResource extends JsonResource
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
                'name' => 'email',
                'type' => 'email'
            ],
            [
                'name' => 'name',
                'type' => 'string'
            ],
            [
                'name' => 'password',
                'type' => 'password'
            ]
        ];

        return compact('fields');
    }
}
