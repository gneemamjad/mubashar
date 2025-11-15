<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdsReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'ad_id',
        'user_id',
        'note',
        'created_at'
    ];

    public $timestamps = true;


     /**
     * Get the user that follows the ad.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the ad that is being followed.
     */
    public function ad()
    {
        return $this->belongsTo(Ad::class)->withTrashed();
    }

    function options()
    {
        return $this->hasMany(AdsReviewOption::class,'review_id','id');
    }

}
