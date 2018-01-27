<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class withdrawRequest extends Model
{
    //
    protected $table = 'withdrawrequest';

    static function add($req){
        $withdraw=new withdrawRequest();
        $withdraw->paypalEmail=$req->email;
        $withdraw->amount=$req->amount;
        $withdraw->user_id=session('user')['id'];
        $withdraw->save();
    }
    
    function user(){
        return $this->belongsTo('App\user'); 
    }

}
