<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class AttributesOption extends Model
{
    use HasTranslations,HasFactory;

    protected $fillable = ['attribute_id', 'key', 'value', 'active'];


    protected $casts = [
        'active' => 'boolean',
    ];


    public $translatable = ['key', 'value'];

    protected $hidden = ['key'];

    protected $appends = ['key_option'];

    public function getKeyOptionAttribute($value)
    {
        return $this->getTranslation('key', app()->getLocale());
    }

    // public function getValueAttribute($value)
    // {
    //     return $this->isTranslatableAttribute('value') ? $this->getTranslation('value', app()->getLocale()) : $value;
    // }

    public function Attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

}
