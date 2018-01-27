<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class userSkills extends Model
{
    //
    protected $table='userskills';

    function skill(){
        return $this->hasOne('App\skill','id','skill_id');
    }

    static function updateSkills($user_id,$skills){
        DB::table('userskills')->where('user_id',$user_id)->delete();
        $insertSkills=array();
        foreach ($skills as $skill){
            $insertSkills[]=['skill_id'=>$skill,'user_id'=>$user_id];
        }
        DB::table('userskills')->insert($insertSkills);
    }




}
