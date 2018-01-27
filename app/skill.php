<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class skill extends Model
{
    //
    protected $table = 'skill';


    static function getAll($id=0){
        $skills=DB::table('skill as s')->select('s.*',DB::raw('us.id is not null as hasSkill'))
            ->leftJoin('userskills as us',function ($q) use ($id){
                $q->on('us.skill_id','=','s.id')->on('us.user_id','=',DB::raw($id));
            })->get();

        return $skills;
    }

    static function getUserSkills($id=0){
        $skills=DB::table('skill as s')->select('s.*',DB::raw('us.id is not null as hasSkill'))
            ->leftJoin('userskills as us',function ($q) {
                $q->on('us.skill_id','=','s.id');
            })->where('us.user_id',$id)->get();
        return $skills;
    }

    static function getPortfolioSkills($ids){
        $skills_id=json_decode($ids);
        return skill::whereIn('id',$skills_id)->get();
    }
  
  function specialization(){
    return $this->belongsTo('App\specialization');
  }
}
