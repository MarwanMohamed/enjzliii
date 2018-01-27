<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class report extends Model
{
    //
    protected $table = 'report';
    protected $fillable = ['isView'];

    static function checkAndAdd($reason_id,$user_id,$refer_id,$type){
        $check=report::where('user_id',$user_id)->where('refer_id',$refer_id)->where('type',$type)->first();
        if($check){
            $report=report::where('id',$check->id)->first();
        }else
            $report=new report();
        $report->user_id=$user_id;
        $report->reason_id=$reason_id;
        $report->type=$type;
        $report->refer_id=$refer_id;
        $report->save();

            return 1;

    }
    
    
    function reportreason(){
        return $this->hasOne('App\reportreason', 'id','reason_id');
    }
    
    function owner(){
        return $this->hasOne('App\user','id','user_id');
    }

}
