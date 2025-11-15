<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdPersonalInfoRequest extends FormRequest
{
    public function authorize()
    {
        return $this->ad->user_id === auth()->id();
    }

    public function rules()
    {
        return [
            'receive_calls' => 'required|boolean',
            'show_as' => 'required|in:name,username',
            'display_name' => 'nullable|string|max:255'
        ];
    }
}
