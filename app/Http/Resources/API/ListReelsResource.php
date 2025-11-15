<?php

namespace App\Http\Resources\API;

use App\Models\Ad;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListReelsResource extends JsonResource
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
            'description' => $this->description,
            'owner' => new AdOwnerResource($this->owner),
            'created_at' => $this->created_at,
            'reel' => $this->reel,
            // 'likes_count' => $this->likes_count ?? 0,
            // 'likes_count' => $this->likes_count <= 1
            //     ? $this->likes_count
            //     : round(pow($this->likes_count, 0.5) + (sin($this->likes_count) * $this->likes_count)) + (($this->id * 2) - $this->likes_count),
            'likes_count' => $this->likes_count <= 1
            ? $this->likes_count
            : round(
                pow($this->likes_count, 0.5)
                + (sin($this->likes_count) * $this->likes_count)
            ) + (($this->id * 2) - $this->likes_count) 
            + (($this->id ?? 0) % 7), // معامل الريل
            'ad_id' => $this->ad?->id,

            // 'is_liked' => $this->isLikedByAuthUser(),
            'is_liked' => $this->relationLoaded('likes') && $this->likes->isNotEmpty(),
        ];
    }
}
