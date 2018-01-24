<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class social extends Model
{
    //

    protected $fillable=['provider','provider_id'];
    function user(){
        return $this->hasOne('App\user','id','user_id');
    }
}
