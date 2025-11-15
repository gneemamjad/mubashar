<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            // ... existing fields ...
            'dial_code' => $this->dial_code,
            'mobile_with_code' => $this->dial_code . $this->mobile,
        ];
    }
}
