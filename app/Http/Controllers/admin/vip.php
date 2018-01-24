<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \App\VIPRequest;
use \App\project;
use \DB;
class vip extends Controller {

    //

    function index(Request $request) {
        $q = $request->q ? $request->q : '';
        $requests = \App\VIPRequest::latest()
                ->with('specialization')
                ->with('budget')
                ->where('status', 0)
                ->paginate(10);
        return view('admin.vip.index', compact('requests', 'q'));
    }

    function showUser(Request $request)
    {
        $q = $request->q ? $request->q : '';
        $words = explode(' ', $q);
        $columnSearch = ['username', 'fname', 'lname', 'email'];
        $status = $request->status ? $request->status : 0;
        $userType = $request->userType ? $request->userType : 0;

        $orderBy = $request->orderBy ? $request->orderBy : 'id';
        $orderByType = $request->asc ? 'asc' : 'desc';
        $orderByExisit = array_search($orderBy, ['username', 'created_at', 'lastLogin', 'status']);

        if ($orderByExisit === false)
            $orderBy = 'id';

        $userTypeExisit = array_search($userType, [1, 2]);
        if ($userTypeExisit === false)
            $userType = 0;
        $query = \App\user::orderBy($orderBy, $orderByType)
            ->where(function ($q) use ($words, $columnSearch) {
                foreach ($words as $word) {
                    foreach ($columnSearch as $column)
                        $q->orWhere($column, 'like', '%' . $word . '%');
                }
            });

        $query->where('isdelete', 0)->where('isVIP',1);
        if ($status == 2)
            $query->where('status', 2);
        else if ($status == 1)
            $query->where('status', '<>', 2);
        if ($userType)
            $query->where('type', $userType);
        $data['users'] = $query->paginate(10);

        $data['users']->withPath(url()->full());
        $data['q'] = $q;
        $data['status'] = $status;
        $data['userType'] = $userType;
        $data['orderBy'] = $orderBy;
        $data['orderByType'] = $orderByType;
        $data['searchParam'] = "q=$q&status=$status&userType=$userType&";
        $data['orderParam'] = "orderBy=$orderBy&orderByType=$orderByType&";


        return view('admin.vip.show', $data);
    }

    function single($id) {
        $request = \App\VIPRequest::find($id);
        $request->update(['isView' => 1]);
        if (!$request)
            abort(404);
        return view('admin.vip.single', compact('request'));
    }
  
  
  
   function statistic(){
        $lastDay=\Carbon\Carbon::today();
        $day=VIPRequest::where('created_at','>',$lastDay)->get();
        $week=VIPRequest::where('created_at','>',$lastDay->subWeeks(1))->get();
        $month=VIPRequest::where('created_at','>',$lastDay->subMonths(1))->get();

        $all=VIPRequest::get();
        $grouped=VIPRequest::select(DB::raw('DATE(created_at) as date, DAY(created_at) as day'), DB::raw('count(*) as count'))
          ->groupBy('date')
          ->where('created_at','>',$lastDay->subMonths(1))
          ->get()->pluck('count','day')->toArray();
     
        $dayP=project::where('created_at','>',$lastDay)->where('isVIP',1)->count();
        $weekP=project::where('created_at','>',$lastDay->subWeeks(1))->where('isVIP',1)->count();
        $monthP=project::where('created_at','>',$lastDay->subMonths(1))->where('isVIP',1)->count();

        $allP=project::where('isVIP',1)->count();
     
     
     $last5=VIPRequest::latest()->limit(5)->get();
        return view('admin/vip/statistic',compact('day','month','week','all','grouped','last5'
                                                ,'dayP','monthP','weekP','allP' ));
      
    }
  
  
  

    function recieved($id) {
        \App\VIPRequest::where('id', $id)->update(['status' => 1]);
        session()->flash('msg', 'تم قبول الطلب');
        return redirect('admin/super/index');
    }

    function cancel($id) {
//       dd('sadsda');
        \App\VIPRequest::where('id', $id)->update(['status' => 2]);
        session()->flash('msg', 'تم الغاء الطلب');
        return redirect('admin/super/index');
    }

    function addUser() {
        return view('admin.vip.addUser');
    }

    function addUserPost(Request $request) {
        $this->validate($request, [
            'fname' => 'required|min:3|max:50',
            'lname' => 'required|min:3|max:50',
            'email' => 'required|min:3|max:50|email|unique:user,email',
        ]);

        $param = $request->only('email', 'fname', 'lname');
        $param['emailConfirm'] = 1;
        $param['isVIP'] = 1;
        $param['finishProfileStep'] = json_encode(["emailConfirm" => 1]);
        \App\user::create($param);
        $token = \App\link::add($request['email'], 6);
        session()->flash('msg', 'تم اضافة مستخدم  vip  وارسال رسالة تفعيل الى بريده الإلكتروني');
        return redirect()->back();
    }

}
