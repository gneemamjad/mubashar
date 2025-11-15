<?php

namespace App\Http\Resources\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdOwnerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $owner = User::find($this->id);

        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->first_name . " " . $this->last_name,
            'user_name' => $this->user_name,
            'user_type' => $this->user_type,
            'mobile' => $this->call == 1 ? '+'.$this->dial_code.ltrim($this->mobile, '0') : '',
            'image' => $this->image != '' ? getMediaUrl($this->image,MEDIA_TYPES["image"]) : getMediaUrl('no_image.jpeg'),
            'can_call' => $this->call,
            'stars' => $owner->average_stars
        ];
    }
}
