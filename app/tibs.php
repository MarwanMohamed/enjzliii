<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tibs extends Model
{
    //
    protected $table = 'tibs';
    
    
    function type(){
        switch ($this->type){
            case 1:
                return 'عرض';
                break;
            case 2: 
                return 'رسائل';
                break;
            
            case 3:
                return 'تواصل معنا';
                break;
            
            default  :
                return 'افتراضي';
                break;
        }
    }
}