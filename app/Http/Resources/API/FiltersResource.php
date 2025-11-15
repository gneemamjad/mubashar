<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FiltersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'key' => $this->id,
            'name' => $this->key,
            'type' => $this->type,
            'options' => AttributesOptionResource::collection($this->attributeOptions),
        ];
    }
}
