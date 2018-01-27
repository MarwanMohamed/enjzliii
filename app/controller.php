<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class controller extends Model
{
    //
    protected $table='controller';
    protected $hidden=['updated_at','deleted_at'];

    function fun(){
        return $this->hasMany('App\function_m','controller_id','id');
    }
    function permission (){
        return $this->hasManyThrough('App\permission','App\function_m','controller_id','function_id')->select('group_permission.*');
    }

    function funWithPerm(){
        return $this->hasMany('App\Function_m','contoller_id','id')->leftJoin('group_permission as gp',function($join){
            $join->on('gp.function_id','=','function.id');
        })->select('function.*',DB::raw('gp.id is not null'));
    }
}
