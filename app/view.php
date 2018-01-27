<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class view extends Model
{
    //
    protected $table = 'view';


    static function checkAndAdd($user_id,$refer_id,$type){
        $check=view::where('user_id',$user_id)->where('refer_id',$refer_id)->where('type',$type)->first();
        if($check){
            return 0;
        }else{
            $view=new view();
            $view->user_id=$user_id;
            $view->type=$type;
            $view->refer_id=$refer_id;
            $view->save();
            return 1;
        }
    }
}
