<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;


    const MEDIA = [
        1 => "image",
        2 => "vedio",
        3 => "360image"
    ];


    protected $table = 'media';

    protected $fillable = [
        'type',
        'name',
        'ad_id',
        'active',
    ];

    /**
     * Get the ad that owns the media.
     */
    public function ad()
    {
        return $this->belongsTo(Ad::class);
    }
}
