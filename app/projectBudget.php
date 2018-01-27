<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class projectBudget extends Model
{
    //
    protected $table = 'projectbudget';


    function fBudget(){
        return ('$'.$this->min.' - $'.$this->max);
    }
}
