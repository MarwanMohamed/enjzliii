<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class projectDescussion extends Model
{
    //
    protected $table = 'projectdescussion';

    function sender(){
        return $this->hasOne('App\user','id','user_id');
    }
    function file(){
        return $this->hasMany('App\file','refer_id')->where('referal_type',5);
    }

}