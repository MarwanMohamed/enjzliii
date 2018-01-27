<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VIPRequest extends Model
{
    //
    protected $table='VIPRequest';
    
     function specialization()
    {
        return $this->belongsTo('App\specialization');
    }
 function budget()
    {
        return $this->hasOne('App\projectBudget', 'id', 'budget_id');
    }

    function status(){
        switch ($this->status){
            case 0:
                return 'جديد'; 
                break;
            case 1: 
                return 'قيد التنفيذ';
                break;
            
        }
    }
}
