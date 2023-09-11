<?php

namespace App\Modules\Organizations\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationsListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'form' => $this->OrganizationFormData->name,
            'director' => $this->director,
            'logo' => $this->logo,
            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
            'days' => $this->days,
        ];;
    }
}
