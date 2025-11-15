<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttributesOptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this['id'] ?? '',
            'attribute_id' => $this['attribute_id'] ?? '',
            'value' => $this['key_option'] ?? '',
            'key_option' => $this['key_option'] ?? ''
        ];
    }
}
