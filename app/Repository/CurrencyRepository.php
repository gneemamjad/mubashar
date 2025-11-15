<?php

namespace App\Repository;

use App\Models\Currency;
use App\Models\ExchangeCurrency;
use Illuminate\Support\Facades\Cache;

class CurrencyRepository
{

    public function updateExchangeRate($rateId, $newRate)
    {
        $rate = ExchangeCurrency::where('id',$rateId)->first();
        $rate->rate = $newRate;
        $rate->save();
        
        return $rate;
    }
   
} 