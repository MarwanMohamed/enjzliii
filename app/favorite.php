<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class favorite extends Model
{
    //
    protected $table = 'favorite';

    function project(){
        return $this->hasOne('App\project','id','refer_id');
    }
    function portfolio(){
        return $this->hasOne('App\portfolio','id','refer_id');
    }
  
    function user(){
        return $this->hasOne('App\user','id','refer_id');
    }
    function bids(){
        return $this->hasManyThrough('App\bid','App\project','id','project_id','refer_id');
    }




    static function checkAndAdd($user_id,$refer_id,$type){
        $check=favorite::where('user_id',$user_id)->where('refer_id',$refer_id)->where('type',$type)->first();
        if($check){
            favorite::where('id',$check->id)->delete();
            return 0;
        }else{
            $like=new favorite();
            $like->user_id=$user_id;
            $like->type=$type;
            $like->refer_id=$refer_id;
            $like->save();
            return 1;
        }
    }


}
