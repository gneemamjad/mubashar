<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class City extends Model
{
    use HasTranslations, HasFactory;


    protected $table = 'city';

    protected $hidden = ['name'];

    protected $fillable = [
        'name',
        'active'
    ];

    public $translatable = ['name'];

    protected $appends = ['city_name'];

    function scopeActive($query)
    {
        return $query->where('active',1);
    }

    public function getCityNameAttribute($value)
    {
        return $this->getTranslation('name', app()->getLocale());
    }

    function areas()
    {
        return $this->hasMany(Area::class,'city_id','id');
    }
}
