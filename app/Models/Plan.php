<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Plan extends Model
{

    use HasTranslations;

    public $translatable = ['title','description'];

    protected $fillable = [
        'title',
        'description',
        'price',
        'old_price',
        'duration_days',
        'is_active'
    ];



    protected $casts = [
        'price' => 'decimal:2',
        'old_price' => 'decimal:2',
    ];

    public function ads()
    {
        return $this->belongsToMany(Ad::class, 'ad_plan');
    }
}
