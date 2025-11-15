<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Area extends Model
{
    use HasTranslations, HasFactory;


    protected $table = 'area';

    protected $hidden = ['name'];

    protected $fillable = [
        'name',
        'active',
        'city_id'
    ];

    public $translatable = ['name'];

    protected $appends = ['area_name'];

    public function getAreaNameAttribute($value)
    {
        return $this->getTranslation('name', app()->getLocale());
    }

    function city()
    {
        return $this->belongsTo(City::class,'city_id','id');    
    }
   
    function scopeActive($query)
    {
        return $query->where('active',1);
    }

}
