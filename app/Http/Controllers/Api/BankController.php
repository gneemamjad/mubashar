<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Traits\Response;
use Illuminate\Http\Request;

class BankController extends Controller
{
    use Response;

    public function index()
    {
        $banks = Bank::where('active', 1)
            ->select('id', 'name', 'icon')
            ->get()
            ->map(function ($bank) {
                return [
                    'id' => $bank->id,
                    'name' => $bank->name,
                    'icon' => $bank->icon ? url('storage/' . $bank->icon) : null
                ];
            });
        // return $this->successWithData('Banks retrieved successfully', []);
        return $this->successWithData('Banks retrieved successfully', $banks);
    }
}
