<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class portfolio extends Model
{
    //
    protected $table = 'portfolio';

    function owner(){
        return $this->hasOne('App\user','id','user_id');
    }
    
      function reports(){
        return $this->hasMany('App\report','refer_id')->where('type',1);
    }

    function likes(){
        return $this->hasMany('App\like','refer_id','id')->where('type',1);
    }
    function views(){
        return $this->hasMany('App\view','refer_id','id')->where('type',1);
    }
    function favorites(){
        return $this->hasMany('App\favorite','refer_id','id')->where('type',1);
    }

    function file()
    {
        return $this->hasMany('App\file', 'refer_id')->where('referal_type', 3);
    }

    static function withFeedback($id=0,$user_id=0){
          $portfolio=  portfolio::select(['portfolio.*',DB::raw('count(distinct view.id) as viewCount'),
              DB::raw('count(distinct like.id) as likeCount'),DB::raw('count(distinct favorite.id) as favoriteCount')])
            ->leftJoin('view',function ($q){
                $q->on('view.refer_id','=','portfolio.id')->on('view.type','=',DB::raw(1));
            })
            ->leftJoin('like',function ($q){
                $q->on('like.refer_id','=','portfolio.id')->on('like.type','=',DB::raw(1));
            })
                ->leftJoin('favorite',function ($q){
                    $q->on('favorite.refer_id','=','portfolio.id')->on('favorite.type','=',DB::raw(1));
                })
             ->groupBy('portfolio.id')
            ->orderBy('portfolio.created_at','desc');
            if($id)
                    return   $portfolio->where('portfolio.id',$id)->first();
            else{
                if($user_id==session('user')['id'])
                    return $portfolio->where('portfolio.user_id',$user_id)->paginate(20);
                else
                    return $portfolio->where('portfolio.user_id',$user_id)->where('isBlock',0)->paginate(20);

            }

    }
    
    function status(){
        if($this->isBlock){
            return 'محظور';
        }else
            return 'مفعل';
        
    }

}
