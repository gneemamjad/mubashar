<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Bank extends Model
{
    use HasFactory;
    use HasTranslations;

    const BANKS = [
        "PayPal" => 1,
        "Stripe" => 2
    ];

    const BANKS_NAME = [
        1 => "PayPal",
        2 => "Stripe"
    ];

    const CURRENCY = [
        1 => "SYP",
        2 => "USD",
        3 => "AED"
    ];

    protected $table = 'banks';
    public $translatable = ['name'];
}
