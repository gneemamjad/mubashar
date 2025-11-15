<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceHistory extends Model
{
    use HasFactory;

    protected $table = 'price_history';
    public $timestamps = true;

    protected $fillable = [
        'ad_id',
        'old_price',
        'new_price',
        'discount',
        'created_at',
        'updated_at'
    ];

    /**
     * Get the ad that owns the price history.
     */
    public function ad()
    {
        return $this->belongsTo(Ad::class);
    }
}
