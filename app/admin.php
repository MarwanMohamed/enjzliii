<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class admin extends Model
{
    //
    protected $table = 'admin';
  function group(){
        return $this->hasOne('App\group_permission','id','permission_group');
    }
    static function havePermission($id){
        return DB::table('admin as a')
            ->leftJoin('permission as gp','a.permission_group','=','gp.PermissionGroup_id')
            ->leftJoin('function as f','f.id','=','gp.function_id')
            ->where('a.id',$id)
            ->orderBy('f.order')
            ->pluck('f.id','f.url')->all();
    }
    static function getMenu($id){
        return DB::table('controller as c')
            ->leftJoin('function as f','f.id','=','c.function_id')
            ->leftJoin('controller as c','c.PermissionGroup_id','=','gp.PermissionGroup_id')
            ->leftJoin('permission as gp','a.permission_group','=','gp.PermissionGroup_id')
            ->where('a.id',$id)
            ->where('f.ismenu',1)
            ->pluck('f.id','f.url')->all();
    }


}
