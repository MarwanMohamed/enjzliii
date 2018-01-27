<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class projectskills extends Model
{
    //
    protected $table = 'projectskills';


    function skill(){
            return $this->hasOne('App\skill','id','skill_id');
    }
}
