<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdsReviewOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'option_id',
        'review_id',
        'created_at'
    ];

    public $timestamps = true;

    function review()
    {
        return $this->belongsTo(AdsReview::class,'review_id','id');    
    }
}
