<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExchangeCurrency extends Model
{

    use HasFactory;
    protected $table = 'exchange_rates';
    protected $fillable = ['rate'];

    protected $with = ['baseCurrency','targetCurrency'];


    function baseCurrency()
    {
        return $this->belongsTo(Currency::class,'base_currency_id','id');    
    }

    function targetCurrency()
    {
        return $this->belongsTo(Currency::class,'target_currency_id','id');    
    }

}
