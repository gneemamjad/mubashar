<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReelLike extends Model
{
    use HasFactory;

    protected $fillable = [
        'reel_id',
        'user_id',
    ];

    /**
     * Get the ad that owns the media.
     */
    public function reel()
    {
        return $this->belongsTo(Reel::class);
    }

    /**
     * Get the ad that owns the media.
     */
    function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
