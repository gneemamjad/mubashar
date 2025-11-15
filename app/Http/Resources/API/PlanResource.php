<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlanResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $locale = app()->getLocale();

        return [
            'id' => $this->id,
            'title' => $this->title,
            // 'description' => $this->description,
            'description' => "",
            'price' => getExchangedPrice($this->price,1,getCurrency()->id),
            'old_price' => getExchangedPrice($this->old_price,1,getCurrency()->id),
            'currency' => getCurrencySymbol(),
            'duration_days' => $this->duration_days,
            'is_active' => $this->is_active,
        ];
    }
}
