<?php

namespace App\Http\Resources\API;

use App\Models\Currency;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
            'title' => $this->title,
            'body' => $this->body,
            'data' => json_decode($this->data),
            'created_at'=> isset($this->created_at) ? $this->created_at->format('Y-m-d h:i') : ""
           
        ];
    }
}
