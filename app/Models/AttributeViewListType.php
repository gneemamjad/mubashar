<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class AttributeViewListType extends Model
{
    use HasTranslations, HasFactory;

    protected $table = 'attribute_view_list_type';

    protected $fillable = [
        'name'
    ];

    public $translatable = ['name'];

    protected $hidden = ['name'];

    protected $appends = ['type_name'];

    public function getTypeNameAttribute($value)
    {
        return $this->getTranslation('name', app()->getLocale());
    }

}
