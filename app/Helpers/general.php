<?php

use App\Models\Currency;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

function getImageUrl($image)
{
    return asset("assets/images/".$image);
}

function getIconUrl($icon)
{
    return asset("assets/icons/".$icon);
}

function getMediaUrl($image, $type = null)
{
    if($type == MEDIA_TYPES["image"])
        return asset("storage/uploads/images/".$image);

    if($type == MEDIA_TYPES["360image"])
        return asset("storage/uploads/360images/".$image);

    if($type == MEDIA_TYPES["vedio"])
        return asset("storage/uploads/vedios/".$image);

    return asset("assets/images/".$image);

}

function uploadMedia($file, $type)
{
    $directory = "uploads";

    if (!$file->isValid()) {
        return false;
    }

    if($type == MEDIA_TYPES["image"])
        $directory = $directory . "/images";
    elseif($type == MEDIA_TYPES["360image"])
        $directory = $directory . "/360images";
    elseif($type == MEDIA_TYPES["vedio"])
        $directory = $directory . "/vedios";

    $fileName = time() . '_'.strval(random_int(99,9999)).'.' . $file->getClientOriginalExtension();
    $filePath = $file->storeAs($directory, $fileName, 'public');

    if (!$filePath) {
        return false;
    }

    return $fileName;
}

function priceRateExchange($price){
    if(Auth::user()){
        $userCurrency = Cache::remember('user_currency_rate_'.Auth::id(), 60*24, function() {
            return Auth::user()->curreny;
        });
        return $price / $userCurrency->rate;
    }

    return $price / Cache::remember('default_currency_rate', 60*24, function() {
        return Currency::first()->rate;
    });
}


function getCurrencySymbol()
{
    if(Auth::user()){
        $userCurrency = Cache::remember('user_currency_symbol_'.Auth::id(), 60*24, function() {
            return Auth::user()->curreny;
        });
        return $userCurrency->name;
    }

    return Cache::remember('default_currency_symbol', 60*24, function() {
        return Currency::first()->name;
    });
}

function getCurrency()
{
    if(Auth::user()){
        $userCurrency = Cache::remember('user_currency_'.Auth::id(), 60*24, function() {
            return Auth::user()->curreny;
        });
        return $userCurrency;
    }

    return Cache::remember('default_currency_', 60*24, function() {
        return Currency::first();
    });
}

function clearAllCache()
{
    Cache::flush();
    return true;
}

function getExchangedPrice($amount, $fromCurrency, $toCurrency)
{
    // return "0";

    if ($fromCurrency == $toCurrency) {
        return  strval(number_format($amount));
    }

    $rate = \DB::table('exchange_rates')
        ->where('base_currency_id', $fromCurrency)
        ->where('target_currency_id', $toCurrency)
        ->value('rate');

    if (!$rate) {
        throw new \Exception("Exchange rate not found for $fromCurrency to $toCurrency");
    }

    return strval(number_format($amount * $rate));
}

