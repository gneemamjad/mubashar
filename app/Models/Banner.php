<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;
    
    const TYPES = [
        'HEADER'        => 1,
        'WITH_IMAGE'    => 2,
        'WITHOUT_IMAGE' => 3,
    ];

    protected $fillable = [
        'type',
        'media',
        'link',
        'author',
        'title',
        'category_id'
    ];

    function category()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }
}
