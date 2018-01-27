<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class attachmentType extends Model
{
    //
    protected $table='attachmentType';
    
    function files(){
        $this->hasMany('App\fileaccept','type_id','id');
    }
}
