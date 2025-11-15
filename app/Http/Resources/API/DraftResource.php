<?php

namespace App\Http\Resources\API;

use App\Models\Ad;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DraftResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "ad" => $this->ad,
            "staticAttributesData" => $this->staticAttributesData,
            "featureAttributesData" => $this->featureAttributesData
        ];
    }
}
