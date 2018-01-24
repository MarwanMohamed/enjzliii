<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class group_permission extends Model
{
    //
    protected $table='permissiongroup';
    protected $hidden=['updated_at','deleted_at'];
}
