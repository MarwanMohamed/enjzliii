<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class contact extends Model
{
    //
    protected $table = 'contact';
    protected $fillable = ['isView'];

    function problem(){
        return $this->hasOne('App\tibs','id','problem_id');
    }

}
