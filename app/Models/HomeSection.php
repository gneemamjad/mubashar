<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class HomeSection extends Model
{

    use HasTranslations;

    protected $table = 'home_sections';

    public $translatable = ['name'];

    protected $fillable = [
        'name',
        'url',
        'active',
        'view_type',
        'queue',
        'limit'
    ];

    protected $casts = [
        'name' => 'array',
        'active' => 'boolean',
    ];
}
