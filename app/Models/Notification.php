<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'title',
        'body',
        'type', // 'all', 'specific_users'
        'status', // 'pending', 'sent', 'failed'
        'sent_at',
        'data'
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'notification_users');
    }
}
