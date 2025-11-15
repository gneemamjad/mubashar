<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class AppDetails extends Model
{
    use HasTranslations ,HasFactory;

    protected $table = 'app_details';

    public $translatable = ['value'];

    protected $fillable = [
        'key',
        'value',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean'
    ];
} 