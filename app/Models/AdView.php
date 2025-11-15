<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdView extends Model
{
    protected $fillable = ['ad_id', 'user_id'];

    /**
     * Get the ad that was viewed.
     */
    public function ad(): BelongsTo
    {
        return $this->belongsTo(Ad::class);
    }

    /**
     * Get the user who viewed the ad.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
