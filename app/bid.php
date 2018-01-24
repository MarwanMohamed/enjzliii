<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class bid extends Model
{
    //
    protected $table = 'bid';
    protected $fillable = ['deliveryDuration', 'cost', 'letter', 'project_id', 'freelancer_id', 'dues', 'files'];

    function user()
    {
        return $this->hasOne('App\user', 'id', 'freelancer_id');
    }

    function project()
    {
        return $this->belongsTo('\App\project');
    }

    function avarage()
    {
        $count = $this->count();
        if ($count) {
            return $this->sum('cost') / $count;
        } else
            return 0;
    }

    function reports()
    {
        return $this->hasMany('App\report', 'refer_id')->where('type', 5);
    }

    function file()
    {
        return $this->hasMany('App\file', 'refer_id')->where('referal_type', 2);
    }

    function owner()
    {
        return $this->hasOne('App\user', 'id', 'freelancer_id');

    }

    static function getAll($id = 0, $fillterTime = 0, $fillterType = 0)
    {
        $order = ($fillterTime) ? 'asc' : 'desc';
        $open_project_day = \App\setting::where('set_id', 'open_project_day')->first(['set_data'])->set_data;

        $query = bid::with([ 'project.owner'])->where('freelancer_id', '=', $id);

//        $query = bid::select(['bid.created_at as bid_cteated_at','pr.status as projectStatus', 'pr.created_at as projectCreatedAT', 'bid.status as status', 'pr.isBlock as pp', 'bid.isBlock as isBlock', 'pf.status as bid_status', 'user.*', 'pr.title as project_title', 'pr.id as project_id'])
//            ->leftJoin('projects as pr', 'pr.id', '=', 'bid.project_id')
//            ->leftJoin('projectfreelancer as pf', function ($q) use ($id) {
//                $q->on('pf.project_id', '=', 'pr.id')->on('pf.freelancer_id', '=', \DB::raw($id));
//            })
//            ->join('user', 'user.id', '=', 'bid.freelancer_id')
//            ->where('bid.freelancer_id', '=', \DB::raw($id));
        if ($fillterType == 1) {
//            $query->whereNull('pf.id');
            $query->where('bid.status', 1)->whereHas('project', function ($q) use ($open_project_day) {
                $q->whereRaw("(created_at + INTERVAL + {$open_project_day} DAY) > NOW()");
            });
        }
        if ($fillterType == 2) {
            $query->where('bid.status', 2);
        }
        if ($fillterType == 3) {
            $query->where('bid.status', 3);
        }
        if ($fillterType == 4) {
            $query->where('bid.status', '!=', 3)->where('bid.status', '!=', 1)->where('bid.status', '!=', 2)->whereHas('project', function ($q) use ($open_project_day) {
                $q->whereRaw("(created_at + INTERVAL + {$open_project_day} DAY) < NOW()")->orWhere('status', 5);
            });

        }

//        if ($fillterType == 5) {
//            $query->where('bid.isBlock', 0)->where('bid.status', '!=', 3)->where('bid.status', '!=', 4)->where('bid.status', '!=', 2)->whereHas('project',function($q) use ($open_project_day){
//                $q->whereRaw("(created_at + INTERVAL + {$open_project_day} DAY) < NOW()");
//            });
//
//        }
//        if ($fillterType == 6) {
//            $query->where('bid.isBlock', 0)->where('bid.status', '!=', 3)->where('bid.status', '!=', 1)->where('bid.status', '!=', 4)->where('bid.status', '!=', 2)->whereHas('project',function($q) use ($open_project_day){
//                $q->whereRaw("(created_at + INTERVAL + {$open_project_day} DAY) < NOW()");
//
//            });
//        } if ($fillterType == 7) {
//            $query->where('bid.isBlock', 1);
//        }
        $bids = $query->orderBy('id', $order)
            ->paginate(8);
//        dd($query->get());
        return $bids;
    }


    static function havebids($userId)
    {
        global $setting;
        $date = Carbon::now();
        $before = $date->subDay($setting['open_project_day']);
        $count = bid::where('bid.freelancer_id', $userId)
            ->join('projects as p', 'p.id', '=', 'bid.project_id')
            ->where('p.created_at', '>', $before)
            ->count();

        return ($count <= $setting['open_bids']);
    }

}
