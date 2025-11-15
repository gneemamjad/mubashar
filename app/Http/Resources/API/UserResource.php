<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->first_name . " " . $this->last_name,
            'user_name' => $this->user_name,
            'user_type' => $this->user_type,
            'mobile' => $this->mobile,
            'image' => $this->image != '' ? getMediaUrl($this->image,MEDIA_TYPES["image"]) : getMediaUrl('no_image.jpeg'),
            'call' => $this->call == null ? false : true,
            'notification' => $this->notification == null ? false : true,
            'email' => $this->email,
            'app_version' => $this->app_version,
            'created_at' =>  $this->created_at,
            'currency' => getCurrency()

        ];
    }
}
