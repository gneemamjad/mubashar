<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'ad_id',
        'created_at'
    ];

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
        return $this->belongsTo(Ad::class);
    }

}
