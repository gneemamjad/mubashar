<?php

namespace App\Http\Resources\API;

use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // $media = $this->media->toArray();

        if ($this->image != '') {
            $exists = $this->media->contains('name', $this->image);
            if (!$exists) {
                // حط object وهمي كأنه Media
                $fakeMedia = new \App\Models\Media([
                    'id' => null,
                    'type' => MEDIA_TYPES['image'],
                    'name' => $this->image,
                ]);
                $this->media->prepend($fakeMedia);
            }
        }
        $attributes = AttributeListsResource::collection($this->attributes);

        $sortedAttributes = $attributes->sortBy(function ($item) {
            return in_array($item['name'], ['عام', 'Static']) ? 0 : 1;
        })->values();
        return [
            'id' => $this->id,
            'ad_number' => $this->ad_number,
            'title' => $this->title,
            'price' => getExchangedPrice($this->price,$this->currency_id,getCurrency()->id),
            'currency' => getCurrencySymbol(),
            'discount' => $this->discount,
            'paid' => (bool) $this->paid,
            // 'premium' => (bool) $this->premium,
            'premium' => (bool) $this->paid,
            'highlighter' => (bool) $this->highlighter,
            'sold' => (bool) $this->sold,
            'rented' => (bool) $this->rented,
            'categories_trace_root' => $this->categories_trace_root,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'status' => $this->approved,
            'followed' => $this->followed,
            'reviewd' => $this->reviewd,
            'owner_reviewd' => $this->owner_reviewd,
            'address' => ($this->city->city_name ?? "") . ", " . ($this->area->area_name ?? ""),
            'created_at' => $this->created_at,
            'description' => $this->description,
            // 'short_description' => strip_tags($this->description),
            'receive_calls' => (bool) $this->recive_calls,
            'attributes_lists' => AttributeListsResource::collection($sortedAttributes),
            'owner' => new AdOwnerResource($this->owner),
            'media' => AdMediaResource::collection($this->media),
            'my_ad' => auth()->user() == null ? false : $this->user_id == auth()->user()->id,
            'image' => $this->image != '' ? getMediaUrl($this->image,MEDIA_TYPES["image"]) : getMediaUrl('no_image.jpeg'),
            'show_contact_us' => (bool) !$this->recive_calls,
            'calender' => (bool) $this->category->have_book,
            'calender_dates' => $this->bookedDates()->pluck('date')->toArray()
        ];
    }
}
