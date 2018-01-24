<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class setting extends Model
{
    //
    protected $table = 'setting';

    protected $fillable = ['set_data'];

    public static function siteSettings($array=array()){
        if(!empty($array))
            $data =  \DB::table('setting')->WhereIn('set_id', $array)->pluck('set_data', 'set_id')->all();
        else
            $data =  \DB::table('setting')->pluck('set_data', 'set_id')->all();
        $output = array_fill_keys($array, "");
        return array_merge($output, $data);
    }

    static  function add($set_id,$set_data){
        $rs=\DB::table('setting')->where('set_id',$set_id)->first();
        if($rs){
            \DB::table('setting')->where('set_id',$set_id)->update(['set_data'=>$set_data]);
        }else{
            \DB::table('setting')->insert(['set_id'=>$set_id,'set_data'=>$set_data]);
        }
    }

}
