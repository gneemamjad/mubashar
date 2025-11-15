<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdAttribute extends Model
{
    use HasFactory;

    protected $table = 'ad_attributes';
    public $timestamps = true;


    protected $fillable = [
        'ad_id',
        'attribute_id',
        'value'
    ];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class, 'attribute_id', 'id');
    }

    public function options()
    {
        return $this->hasMany(AdAttributesOption::class, 'ad_attribute_id', 'id');
    }


}
