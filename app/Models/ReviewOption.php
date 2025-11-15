<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ReviewOption extends Model
{
    use HasTranslations, HasFactory;

    protected $table = 'review_options';

    public $translatable = ['text'];

    protected $fillable = [
        'text',
        'active',
        'created_at',
        'updated_at'
    ];

}
