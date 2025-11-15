<?php

namespace App\Http\Resources\API;

use App\Models\Ad;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListAdsResource extends JsonResource
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
            'ad_number' => $this->ad_number,
            'title' => $this->title,
            'description' => strip_tags($this->description),
            'price' => getExchangedPrice($this->price,$this->currency_id,getCurrency()->id),
            // 'price' => "0",
            'currency' => getCurrencySymbol(),
            'discount' => $this->discount,
            // 'discount' => null,
            'paid' => $this->paid,
            // 'premium' => (bool) $this->premium,
            'premium' => (bool) $this->paid,
            'highlighter' => (bool) $this->highlighter,
            // 'sold' => (bool) $this->sold,
            // 'rented' => (bool) $this->rented,
            'status' => $this->status,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'created_at' => $this->created_at,
            'address' => ($this->city->city_name ?? "") . ", " . ($this->area->area_name ?? ""),
            // 'image' => $this->image != '' ? getMediaUrl($this->image,MEDIA_TYPES["image"]) : getMediaUrl('no_image.jpeg'),
            'image' => $this->image != '' 
            ? (in_array(strtolower(pathinfo($this->image, PATHINFO_EXTENSION)), ['mp4', 'MP4', 'Mov', 'mov', 'avi', 'MOV', 'AVI'])
                ? getMediaUrl($this->image, MEDIA_TYPES["vedio"])   // if video
                : getMediaUrl($this->image, MEDIA_TYPES["image"])) // if image
            : getMediaUrl('no_image.jpeg'),
            'views_count' => ($request->routeIs('getMyAds') && $request->type == Ad::STATUS['APPROVED']) ? count($this->views) : null
        ];
    }
}
