<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class conversation extends Model
{
    //
    protected $table = 'conversation';
    protected $fillable = ['isView'];

    function messages(){
        return $this->hasMany('App\message')->orderBy('id');
    }

    function sender(){
        return $this->hasOne('App\user','id','sender_id');
    }

    function project(){
        return $this->belongsTo('App\project');
    }

    function reciever(){
        return $this->hasOne('App\user','id','reciever_id');
    }

    function friend($user_id=0){
        $user_id=($user_id)?$user_id:session('user')['id'];
        if($this->sender_id==$user_id){
            return $this->reciever;
        }else{
            return $this->sender;
        }
    }
    
    
    function friendAPI($user_id=0){
        if($this->sender_id==$user_id){
            return $this->reciever;
        }else{
            return $this->sender;
        }
    }
      function freelancer(){
        $user_id=$this->project->projectOwner_id;
        if($this->sender_id==$user_id){
            return $this->reciever;
        }else{
            return $this->sender;
        }
    }

    function lastMessage(){
       $message= $this->hasMany('App\message')->orderBy('id','desc');
       if(sizeof($message))
           return $message;
       else
           return 0;
    }

    static function statistic($user_id=0){
        $statistic=conversation::select(DB::raw('count(conversation.id) as allCount ,sum(case when reciever_id = '.$user_id.' then 1 else 0 end) as revive') )
            ->where('sender_id',$user_id)
            ->orWhere('reciever_id',$user_id)
            ->first();
        return $statistic;
    }


    static function unssen($user_id=0){

        $statistic=message::select(DB::raw('count(DISTINCT c.id) as allCount ,count(DISTINCT cc.id) as revive') )
            ->where(function($q) use ($user_id){
                $q->where('message.reciever_id',$user_id);
            })
            ->groupBy('conversation_id')
            ->where('seen',0)
            ->leftJoin('conversation as c','conversation_id','=','c.id')
            ->leftJoin('conversation as cc',function($q) use($user_id){
                $q->on('conversation_id','=','cc.id')->on('c.reciever_id','=',DB::raw($user_id));
        })
            ->first();
        return $statistic;
    }
  
  function isClose() {
        global $setting;
        $status = $this->project->status;
        if ($this->status == 2) {
                if ($status || session('user')['status'] == 1) {
                    $date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at);
                    $now = \Carbon\Carbon::now();
                    if ($now->diffInDays($date) > $setting['open_project_day']) {
//             project close
            return 'هذه المحادثة مغلقة';
                    } else {
                        return 0;
                    }
                } else {
                    return 'تم حظر حسابك الرجاء مراجعة الإدارة';
                }
            
        } else if ($status == 3) {
            return 0;
        } else {
//        submited close
            return 'هذه المحادثة مغلقة';
        }
    }

  
}
