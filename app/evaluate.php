<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class evaluate extends Model
{
    //
    protected $table = 'evaluate';


    function project(){
        return $this->hasOne('App\project','id','project_id');
    }
    function user(){
        return $this->hasOne('App\user','id','freelancer_id');
    }
    function evalutedUser(){
       return $this->hasOne('App\user','id','evaluated_id');
    }


        function avg(){
            if($this->count()) {
                    $sum= $this->sum('quality')+
                          $this->sum('experience')+
                          $this->sum('workAgain')+
                          $this->sum('ProfessionalAtWork')+
                         $this->sum('CommunicationAndMonitoring');
                    return $sum/$this->count();
                }else
                return 0;
        }
}
