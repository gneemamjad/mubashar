<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdAttributesOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'ad_attribute_id',
        'ad_attribute_option_id'
    ];
    public $timestamps = true;



    public function attribute()
    {
        return $this->belongsTo(Attribute::class, 'attribute_id', 'id');
    }

    public function options()
    {
        return $this->hasMany(AdAttributesOption::class, 'ad_attribute_id', 'id');
    }

    public function option()
    {
        return $this->belongsTo(AttributesOption::class,'ad_attribute_option_id','id');
    }
}
