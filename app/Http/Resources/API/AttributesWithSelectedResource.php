<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttributesWithSelectedResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data =  [
            'id' => $this->id,
            'title' => $this->attribute_key,
            'type' => $this->type,
            'value' => $this->value,
            'options' => $this->attributeOptions,
            'required' => strval($this->required),
            'selected_value'=>$this->selectedValue
        ];
        

        if (isset($this->currencies) && $this->type == 'currency') {
            $data['currencies'] = $this->currencies;
        }

        return $data;
    }
}
