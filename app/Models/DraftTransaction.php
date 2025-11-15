<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DraftTransaction extends Model
{
    use HasFactory;

    protected $fillable = ['ad_id','bank_id','transaction_id', 'status','amount','capture_id'];

    function ad()
    {
        return $this->belongsTo(Ad::class,'ad_id','id');    
    }

    function user()
    {
        return $this->belongsTo(User::class,'user_id','id');    
    }

}
