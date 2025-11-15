<?php

namespace App\Http\Resources\API;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BannersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "type" => $this->type,
            "media" => $this->media,
            "link" => $this->link,
            "author" => $this->author,
            "title" => $this->title
        ];
    }
}
