<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\ExchangeCurrency;
use App\Services\CurrencyService;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{

    public function __construct(protected CurrencyService $currencyService)
    {
        // Use custom permission middleware
        $this->middleware(['auth:admin', 'custom.permission:list currencies,admin'])->only(['index']);
        $this->middleware(['auth:admin', 'custom.permission:edit currencies,admin'])->only(['updateRate']);
    }

    public function index()
    {
        $title = __('admin.sidebar.currencies');
        $page = __('admin.sidebar.currencies_management');
        $currencies = ExchangeCurrency::all();    
        return view('admin.currency.index',compact('currencies','title','page'));
    }

    public function updateRate(Request $request)
    {
        $request->validate([
            'rateId' => 'required|exists:exchange_rates,id',
            'new_rate' => 'required|numeric|min:0'
        ]);

        try {
            $currency = $this->currencyService->updateExchangeCurrencyRate(
                $request->rateId,
                $request->new_rate
            );

            return response()->json([
                'success' => true,
                'message' => __('currency.updated_successfully'),
                'data' => $currency
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('currency.failed_to_update_currency_rate'),
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
