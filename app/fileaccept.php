<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class fileaccept extends Model
{
    //
    protected $table='fileaccept';
    
    function file(){
    return $this->hasOne('app\fileType','id','fileType_id');
    }
}
