<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class projectFreelancer extends Model
{
    //
    protected $table = 'projectfreelancer';


    function user(){
        return $this->hasOne('App\user','id','freelancer_id');
    }
}
