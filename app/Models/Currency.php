<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Currency extends Model
{
    use HasFactory;
    use HasTranslations;
    protected $table = 'currency';

    public $translatable = ['name'];
    protected $fillable = ['name','rate', 'active'];

    protected $casts = [
        'rate' => 'float',
    ];

    const CURRENCY = [
        "1" => "SYP",
        "2" => "USD",
        "3" => "AED"
    ];


    public static function getCurrency($id)
    {
        return self::CURRENCY[$id] ?? null;
    }


}
