<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    protected function create(array $data)
    {
        return User::create([
            // ... existing fields ...
            'dial_code' => $data['dial_code'] ?? null,
        ]);
    }
}
