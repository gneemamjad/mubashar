<?php

namespace App\Services;

use App\Repository\CurrencyRepository;

class CurrencyService
{
    public function __construct(protected CurrencyRepository $currencyRepository)
    {
    }

    public function updateExchangeCurrencyRate($rateId, $newRate)
    {
        $currency = $this->currencyRepository->updateExchangeRate($rateId, $newRate);
        clearAllCache();
        
        return $currency;
    }
} 