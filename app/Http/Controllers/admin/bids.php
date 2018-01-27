<?php

namespace App\Http\Controllers\admin;

use App\bid;
use App\country;
use App\link;
use App\notifcation;
use \Illuminate\Support\Facades\DB;
use App\portfolio;
use App\project;
use App\setting;
use App\skill;
use Validator;
use App\user;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class bids extends Controller {

    //


    function index($id=0,Request $request) {
        $q = $request->q ? $request->q : '';
        $owner = $request->owner ? $request->owner : '';
        $words = explode(' ', $q);
        $ownerWords = explode(' ', $owner);
        $columnSearchUser = ['username', 'fname', 'lname', 'email'];
        $columnSearchProject = ['title', 'description'];
        $columnSearchBid = ['letter'];
        $status = $request->status ? $request->status : 0;
        $status = ($status > 1 && $status <= 7) ? $status : 0;
        $orderBy = $request->orderBy ? $request->orderBy : 'id';
        $orderByType = $request->asc ? 'asc' : 'desc';
        $orderByExisit = array_search($orderBy, ['created_at', 'status']);

        if ($orderByExisit === false)
            $orderBy = 'id';

        $query = bid::orderBy($orderBy, $orderByType)
                ->where(function ($qe) use($columnSearchBid, $columnSearchProject, $q) {
            foreach ($columnSearchBid as $column)
                $qe->orWhere($column, 'like', '%' . $q . '%');
        });

        if($id){
            $query->where('project_id',$id);
        }

        
        if (sizeof($ownerWords)) {
            $query->whereHas('owner', function ($q) use($ownerWords, $columnSearchUser) {
                $q->whereRaw('0=1');
                foreach ($ownerWords as $word) {
                    foreach ($columnSearchUser as $column)
                        $q->orWhere($column, 'like', '%' . $word . '%');
                }
            });
        }
        if ($status) {
            if ($status == 2 || $status == 5) {
                global $setting;
                $date = \Carbon\Carbon::now();
                $before = $date->subDay($setting['open_project_day']);

                $query->whereHas('project', function($q) use ($status, $before) {

                    $q->where('status', 2);
                    if ($status == 2)
                        $q->where('created_at', '>', $before->toDateTimeString());
                    else
                        $q->where('created_at', '<=', $before->toDateTimeString());
                });
            } else if ($status == 7)
                $query->whereHas('project', function($q) {
                    $q->where('isBlock', 1);
                });
            else
                $query->whereHas('project', function($q) use($status) {
                    $q->where('status', $status);
                    $q->where('isBlock', 0);
                });
        }
      

//        else if ($status == 1)
//            $query->where('status', '<>', 2);
//        if ($userType)
//            $query->where('type', $userType);
        $data['bids'] = $query->with('owner')->with('project')->paginate(10);

        $data['bids']->withPath(url()->full());
        $data['q'] = $q;
        $data['owner'] = $owner;
        $data['status'] = $status;
        $data['orderBy'] = $orderBy;
        $data['orderByType'] = $orderByType;
        $data['searchParam'] = "q=$q&status=$status&status=$status&";
        $data['orderParam'] = "orderBy=$orderBy&orderByType=$orderByType&";
        session(['searchParam' => $data['searchParam'], 'orderParam' => $data['orderParam']]);


        return view('admin/bids/index', $data);
    }
  
  
   function statistic(){
        $lastDay=\Carbon\Carbon::today();
        $day=bid::where('created_at','>',$lastDay)->count();
        $week=bid::where('created_at','>',$lastDay->subWeeks(1))->count();
        $month=bid::where('created_at','>',$lastDay->subMonths(1))->count();
              $now=\Carbon\Carbon::now();

        $all=bid::count();
        $grouped=bid::select(DB::raw('DATE(created_at) as date, DAY(created_at) as day'), DB::raw('count(*) as count'))
          ->groupBy('date')
          ->where('created_at','>',$lastDay->subMonths(1))
          ->get()->pluck('count','day')->toArray();
        return view('admin/bids/statistic',compact('day','month','week','all','grouped'));
      
    }

    function single($id) {
        $bid = bid::where('id', $id)
                ->with('owner')
                ->withCount('project')
                ->first();
        if ($bid) {
            $data['bid'] = $bid;
            return view('admin.bids.single', $data);
        } else {
            $this->error('هذا العرض غير موجود');
        }
    }

    function block(Request $request) {
            $this->validate($request, [
                    'id' => 'required|integer',
                    'blockReason' => 'required|min:20|max:500',
        ]);
        $id=$request->id;
        bid::where('id', $id)->update(['isBlock' => 1,'blockReason'=>$request->blockReason]);
        session()->flash('msg', 'تم حظر العرض');
        $bid = bid::find($id);
        if ($bid)
            notifcation::addNew(1, 0, $bid->freelancer_id, 'رسالة ادارية', 'تم حظر عرضك على مشروع' . $bid->title . ' لمزيد من المعلومات راجع الإدارة.', 0);
        //this new  added by me
        /////////////////////////////////////////////////
        $user = \App\user::find($bid->freelancer_id);
        if(!empty($user->device_token)){
            $m1 = ['en' => 'تم حظر عرضك على مشروع' . $bid->title . ' لمزيد من المعلومات راجع الإدارة.'];
            $url = url('/').'/project/'.$bid->project->id.'-'.$bid->project->title;
            sendNotification($m1, $user->device_token, 'project',$url);
        }
        //////////////////////////////////////////////////
        return redirect(redirect()->back()->getTargetUrl());
    }

    function unblock($id) {
        bid::where('id', $id)->update(['isBlock' => 0]);
        session()->flash('msg', 'تم تفعيل العرض');
        $bid = bid::find($id);
        if ($bid)
            notifcation::addNew(1, 0, $bid->project->projectOwner_id, 'رسالة ادارية', 'تم الغاء حظر عرضك على مشروع  ' . $bid->project->title . ' لمزيد من المعلومات راجع الإدارة.', 0);
        //this new  added by me
        /////////////////////////////////////////////////
        $user = \App\user::find($bid->project->projectOwner_id);
        if(!empty($user->device_token)){
            $m1 = ['en' =>  'تم الغاء حظر عرضك على مشروع  ' . $bid->project->title . ' لمزيد من المعلومات راجع الإدارة.'];
            $url = url('/').'/project/'.$bid->project->id.'-'.$bid->project->title;
            sendNotification($m1, $user->device_token, 'project',$url);
        }
        //////////////////////////////////////////////////
        return redirect(redirect()->back()->getTargetUrl());
    }

}
