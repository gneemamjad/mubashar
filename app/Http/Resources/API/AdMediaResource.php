<?php

namespace App\Http\Resources\API;

use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdMediaResource extends JsonResource
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
            'key_type' => $this->type,
            'type' => Media::MEDIA[$this->type] ?? $this->type,
            'url' => getMediaUrl($this->name, $this->type),
        ];
    }
}
