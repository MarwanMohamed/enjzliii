<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class message extends Model
{
    //
    protected $table = 'message';
    protected $fillable = ['conversation_id','sender_id','content','reciever_id','seen_api'];
    protected $hidden = ['VIPUser','VIPSeen'];

    function sender(){
        return $this->hasOne('App\user','id','sender_id');
    }


        function project(){
            return $this->belongTo('App\project');
        }


    function files(){
        return $this->hasMany('App\file','refer_id','id')->where('referal_type',4);
    }




}
