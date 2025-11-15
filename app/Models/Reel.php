<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reel extends Model
{
    use HasFactory;

    protected $table = 'reels';

    const STATUS = [
        "PENDING" => 0,
        "APPROVED" => 1,
        "NOT_APPROVED" => 2
    ];

    protected $fillable = [
        'ad_id',
        'user_id',
        'description',
        'reel',
        'status'
    ];

    function scopeApproved($query)
    {
        return $query->where('status',self::STATUS['APPROVED']);
    }

    function scopeNotApproved($query)
    {
        return $query->where('status',self::STATUS['NOT_APPROVED']);
    }

    function scopePending($query)
    {
        return $query->where('status',self::STATUS["PENDING"]);
    }
    
    /**
     * Get the ad that owns the reel.
     */
    public function ad()
    {
        return $this->belongsTo(Ad::class);
    }

    /**
     * Get the owner that owns the reel.
     */
    function owner()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    /**
     * Get the like that owns the media.
     */
    public function likes()
    {
        return $this->hasMany(ReelLike::class);
    }

    // public function isLikedByAuthUser(): bool
    // {
    //     $userId = auth()->id();

    //     if (!$userId) {
    //         return false;
    //     }

    //     return $this->likes()
    //         ->where('user_id', $userId)
    //         ->exists();
    // }
}
