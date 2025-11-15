<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PriceHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'old_price' => getExchangedPrice($this->old_price,1,getCurrency()->id),
            'new_price' => getExchangedPrice($this->new_price,1,getCurrency()->id),
            'currency' => getCurrencySymbol(),
            'status' => $this->new_price > $this->old_price ? "up" : ($this->new_price < $this->old_price ? "down" : "no_change"),
            'discount' => $this->discount ?? 0,
            'created_at' => $this->created_at,
        ];
    }
}
