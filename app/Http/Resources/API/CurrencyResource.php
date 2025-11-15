<?php

namespace App\Http\Resources\API;

use App\Models\Currency;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CurrencyResource extends JsonResource
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
            'symbol' => $this->name,
            'name'=> Currency::CURRENCY[$this->id]           
           
        ];
    }
}
