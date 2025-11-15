<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Attribute extends Model
{
    use HasTranslations,HasFactory;

    const TYPE = [
        "select",
        "boolean",
        "text",
        "numeric",
        "date",
        "radio",
        "multiselect"
    ];

    public $translatable = ['key'];

    protected $fillable = ['id','type','key', 'value', 'type', 'options','list_type_id','required'];

    // protected $hidden = ['key'];

    protected $appends = ['attribute_key','currencies'];

    public function getAttributeKeyAttribute()
    {
        return $this->getTranslation('key', app()->getLocale());
    }
    public function options()
    {
        return $this->hasMany(AdAttributesOption::class);
    }

    public function typeList()
    {
        return $this->belongsTo(AttributeViewListType::class,'list_type_id','id');
    }

    public function attributeOptions()
    {
        return $this->hasMany(AttributesOption::class);
    }

    // protected $attributes = [
    //     'currencies' => '[]'
    // ];

    public function setCurrenciesAttribute($value)
    {
        $this->attributes['currencies'] = json_encode($value);
    }

    public function getCurrenciesAttribute($value)
    {
        return json_decode($value, true) ?? [];
    }
}
