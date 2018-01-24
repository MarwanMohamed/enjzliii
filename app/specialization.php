<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class specialization extends Model
{
    //
    protected $table = 'specialization';

  
  function skills(){
    return $this->hasMany('App\skill');
  }
}
