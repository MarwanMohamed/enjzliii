<?php

namespace App\Http\Controllers\admin;

use App\project;
use \App\portfolio;
use \App\user;
use Illuminate\Http\Request;
use \App\Http\Controllers\Controller;
use \App\report;
use \Db;
class reports extends Controller {

    function project(Request $request) {
        $q = $request->q ? $request->q : '';
        $status = $request->status ? $request->status : 0;

        $query = project::whereHas('reports')->with('reports');
        if ($status)
            $query->whereHas('reports', function($q) use($status) {
                if ($status == 1)
                    $q->where('status', 0);
                else
                    $q->where('status', 1);
            });
        $query->where(function ($query) use ($q) {
            $query->where('title', 'like', '%' . $q . '%');
            $query->orWhere('description', 'like', '%' . $q . '%');
        });
        $projects = $query->paginate();


        $projects->withPath(url()->full());
        return view('admin.reports.project', compact('projects', 'q', 'status'));
    }
    function bids(Request $request) {
        $q = $request->q ? $request->q : '';
        $status = $request->status ? $request->status : 0;

        $query = \App\bid::whereHas('reports')->with('reports');
        if ($status)
            $query->whereHas('reports', function($q) use($status) {
                if ($status == 1)
                    $q->where('status', 0);
                else
                    $q->where('status', 1);
            });
        $query->where(function ($query) use ($q) {
            $query->where('letter', 'like', '%' . $q . '%');
        });
        $bids = $query->paginate();


        $bids->withPath(url()->full());
        return view('admin.reports.bids', compact('bids', 'q', 'status'));
    }

  
  
   function statistic(){
        $lastDay=\Carbon\Carbon::today();
        $day=report::where('created_at','>',$lastDay)->get();
        $week=report::where('created_at','>',$lastDay->subWeeks(1))->get();
        $month=report::where('created_at','>',$lastDay->subMonths(1))->get();

        $all=report::get();
        $grouped=report::select(DB::raw('DATE(created_at) as date, DAY(created_at) as day'), DB::raw('count(*) as count'))
          ->groupBy('date')
          ->where('created_at','>',$lastDay->subMonths(1))
          ->get()->pluck('count','day')->toArray();
        return view('admin/reports/statistic',compact('day','month','week','all','grouped'));
      
    }
  
  
  
    function portifolio(Request $request) {
        $q = $request->q ? $request->q : '';
        $status = $request->status ? $request->status : 0;
        $query = portfolio::whereHas('reports')->with('reports');
        if ($status)
            $query->whereHas('reports', function($q) use($status) {
                if ($status == 1)
                    $q->where('status', 0);
                else
                    $q->where('status', 1);
            });

        $query->with('owner')
                ->where(function ($query) use ($q) {
                    $query->where('title', 'like', '%' . $q . '%');
                    $query->orWhere('description', 'like', '%' . $q . '%');
                });
        $portfolios = $query->paginate();


        $portfolios->withPath(url()->full());
        return view('admin.reports.portfolio', compact('portfolios', 'q', 'status'));
    }

    function users(Request $request) {
        $q = $request->q ? $request->q : '';
        $status = $request->status ? $request->status : 0;
        $query = user::whereHas('reports')->with('reports');
        if ($status)
            $query->whereHas('reports', function($q) use($status) {
                if ($status == 1)
                    $q->where('status', 0);
                else
                    $q->where('status', 1);
            });

        $query->with('myProjects')
                ->where(function ($query) use ($q) {
                    $query->where('fname', 'like', '%' . $q . '%');
                    $query->orWhere('lname', 'like', '%' . $q . '%');
                    $query->orWhere('username', 'like', '%' . $q . '%');
                    $query->orWhere('email', 'like', '%' . $q . '%');
                });
        $users = $query->paginate();


        $users->withPath(url()->full());
        return view('admin.reports.users', compact('users', 'q', 'status'));
    }

    function show($type, $id) {
        \App\report::where(['refer_id'=> $id])->first()->update(['isView' => 1]);
        $data = [];
        if ($type == 2) {
            $data['project'] = project::with('reports')->with('reports.owner')->with('reports.reportreason')->find($id);
            $type = 'project';
            if ($data['project'])
                return view('admin.reports.single', $data);
        }else if ($type == 1) {
            $portfolio = portfolio::with('reports')->with('reports.owner')->with('reports.reportreason')->find($id);
            if ($portfolio)
                return view('admin.reports.singlePortfolio', compact('portfolio'));

        }else if($type == 5){
            $data['bid'] = \App\bid::with('reports')->with('reports.owner')->with('reports.reportreason')->find($id);
           \App\report::where(['type'=>5,'refer_id'=> $id])->update(['status'=>1]);
            if ($data['bid'])
                return view('admin.reports.singleBid', $data);
        } else {
            $user = user::with('reports')->with('reports.owner')->with('reports.reportreason')->find($id);
            if ($user)
                return view('admin.reports.singleUser', compact('user'));
        }
        $this->error('هذا العنصر غير موجود');
    }

    function blockPortfolio($id) {
        portfolio::where('id', $id)->update(['isBlock' => 1]);
        session()->flash('msg', 'تم حظر هذا العمل');
        \App\report::where('type', 1)->where('refer_id', $id)->update(['status' => 1]);
        return redirect(url()->previous());
    }

    function blockProject($id) {
        project::where('id', $id)->update(['isBlock' => 1]);
        session()->flash('msg', 'تم حظر هذا المشروع');
        \App\report::where('type',2)->where('refer_id', $id)->update(['status' => 1]);
        return redirect(url()->previous());
    }

    function blockUser($id) {
        user::where('id', $id)->update(['status' => 2, 'blockReason' => 'تم حظر المستخدم بسبب التبليغات']);
        session()->flash('msg', 'تم حظر هذا المستخدم');
        \App\report::where('type', 3)->where('refer_id', $id)->update(['status' => 1]);
        return redirect(url()->previous());
    }

    function unblockPortfolio($id) {
        portfolio::where('id', $id)->update(['isBlock' => 0]);
        session()->flash('msg', 'تم الغاء الحظر');

        return redirect(url()->previous());
    }

}
