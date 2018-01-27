<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class adminLog extends Model
{
    //
    protected $table='adminLog';
    
  protected $fillable=['action','refer_id','refer_type','note','admin_id'];
   static function addPR($refere_id,$action,$note){
      $param=compact('action','refer_id','note');
      $param['refer_type']='PR';
      $param['admin_id']=session('admin')['id'];
      self::create($param);
    }
}
