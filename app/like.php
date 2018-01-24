<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class like extends Model
{
    //
    protected $table = 'like';


    static function checkAndAdd($user_id,$refer_id,$type){
        $check=like::where('user_id',$user_id)->where('refer_id',$refer_id)->where('type',$type)->first();
        if($check){
            like::where('user_id',$user_id)->where('refer_id',$refer_id)->where('type',$type)->delete();
            return 0;
        }else{
            $like=new like();
            $like->user_id=$user_id;
            $like->type=$type;
            $like->refer_id=$refer_id;
            $like->save();
            return 1;
        }
    }
}
