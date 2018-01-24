<?php

namespace App\Http\Controllers\admin;

use \App\transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \App\user;

class transactions extends Controller
{
    //
    function index(Request $request)
    {
        $q = $request->q ? $request->q : '';
        $type = $request->type ? $request->type : '';


        $transactions = \App\transaction::whereHas('sender', function ($query) use ($q, $type) {
            $query->where('fname', 'like', '%' . $q . '%');
            $query->orWhere('lname', 'like', '%' . $q . '%');
            $query->orWhere('email', 'like', '%' . $q . '%');
            $query->orWhere('username', 'like', '%' . $q . '%');
        })->whereHas('reciever', function ($query) use ($q) {
            $query->where('fname', 'like', '%' . $q . '%');
            $query->orWhere('lname', 'like', '%' . $q . '%');
            $query->orWhere('email', 'like', '%' . $q . '%');
            $query->orWhere('username', 'like', '%' . $q . '%');
        });

//        if ($type) {
//
//            $transactions->where('process_type',$type);
////            if($type == 1) {$transactions->where('sender_id','=',0)->where('reciever_id','!=',0)->latest()->paginate(10);}
////            if($type == 3) {$transactions->where('sender_id','!=',0)->where('reciever_id','!=',0)->latest()->paginate(10);}
////            if($type == 2){ $transactions->where('reciever_id','=',0)->latest()->paginate(10);}
//        }
        $transactions = $transactions->latest()->paginate(10);

        if(empty($q) && !empty($type)){
            $transactions = \App\transaction::where('process_type',$type)->latest()->paginate(10);
        }
        if(empty($q) && empty($type)){
            $transactions = \App\transaction::latest()->paginate(10);
        }
        return view('admin/transaction/index', compact('transactions', 'q', 'type'));
    }


    function user($id, Request $request)
    {
        $type = $request->type ? $request->type : 0;
        $user = \App\user::find($id);
        if ($user) {
            $transactions = \App\transaction::with('sender')->with('reciever')->latest();
            if ($type == 1) {
                $transactions->where('sender_id', $id);
            } else if ($type == 2) {
                $transactions->where('reciever_id', $id);
            } else {
                $transactions->where('sender_id', $id)->orWhere('reciever_id', $id);
            }
            $transactions = $transactions->latest()->paginate(10);
            return view('admin/transaction/index', compact('transactions', 'q', 'user'));
        } else {
            session()->flash('error', 'هذا المستخدم غير موجود');
            abort(404);
        }
    }

    function statistic()
    {
        $dateDay = \Carbon\Carbon::now()->subDay(1);
        $dateWeak = \Carbon\Carbon::now()->subWeek(1);
        $dateMonth = \Carbon\Carbon::now()->subMonth(1);
        $all = transaction::all();
        $day = transaction::where('created_at', '>', $dateDay)->get();
        $month = transaction::where('created_at', '>', $dateWeak)->get();
        $week = transaction::where('created_at', '>', $dateMonth)->get();

        $balanceU = user::sum('balance');
        $suspended_balanceU = user::sum('suspended_balance');

        $user = \App\user::get();
        return view('admin.transaction.statistic', compact('all', 'day', 'month', 'week', 'balanceU', 'suspended_balanceU'));
    }

    function withdrawrequest()
    {
        $withdraws = \App\withdrawRequest::where('status', 1)->with('user')->paginate(10);
        return view('admin.transaction.withdraw', compact('withdraws'));
    }

    function withdraw(Request $request)
    {
        $id = $request->id;
        $transaction = \App\withdrawRequest::where('status', 1)->find($id);
        if ($transaction) {
            return view('admin.error', ['msg' => 'لم يتم تفعيل العملية بعد']);
        } else {
            return view('admin.error', ['msg' => 'خطأ في البيانات المدخلة']);
        }
    }


}
