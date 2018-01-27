<?php

namespace App\Http\Controllers\admin;

use App\conversation;
use \App\message;
use \App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \DB;
class conversations extends Controller {

    //
    function index(Request $request) {
        $q = $request->q ? $request->q : '';
        $username = $request->username ? $request->username : '';
       $query= conversation::whereHas('messages')->latest();
      if($username)
          $query->whereHas('sender', function($query) use ($username) {
                           $username= str_replace(' ', '%', $username);
                            $query->where('username', 'like', '%' . $username . '%');
                            $query->orWhere('email', 'like', '%' . $username . '%');
                            $query->orWhereRaw('concat(fname," ",lname) like "%' . $username . '%"');
                        });
        $data['conversations']=$query->whereHas('project', function($query) use ($q) {
                            $query->where('title', 'like', '%' . $q . '%')->orWhere('description', 'like', '%' . $q . '%');
                        })->
                        with('project')->with('lastMessage')->with('project.owner')->with('sender')->with('reciever')->paginate(10);
        $data['q'] = $q;
        $data['username'] = $username;
        return view('admin/conversation/index', $data);
    }

    function single($id) {
        $conversation = conversation::
                with('project')->with('lastMessage')->with('project.owner')->with('sender')->with('reciever')->find($id);

        $conversation->update(['isView' => 1]);
        if ($conversation) {
            $data['conversation'] = $conversation;
            return view('admin.conversation.single', $data);
        } else {
            $this->error('هذا العرض غير موجود');
        }
    }

  
  
   function statistic(){
        $lastDay=\Carbon\Carbon::today();
        $day=conversation::where('created_at','>',$lastDay)->count();
        $week=conversation::where('created_at','>',$lastDay->subWeeks(1))->count();
        $month=conversation::where('created_at','>',$lastDay->subMonths(1))->count();
              $now=\Carbon\Carbon::now();

        $all=conversation::count();
        $grouped=conversation::select(DB::raw('DATE(created_at) as date, DAY(created_at) as day'), DB::raw('count(*) as count'))
          ->groupBy('date')
          ->where('created_at','>',$lastDay->subMonths(1))
          ->get()->pluck('count','day')->toArray();
           $last5=conversation::with('lastMessage')->whereHas('messages')->limit(5)->latest()->get();

        return view('admin/conversation/statistic',compact('day','month','week','all','grouped','last5'));
      
    }
  
  
  
    function send(Request $request) {
        $this->validate($request, [
            'conversation_id' => 'required|exists:conversation,id',
            'sender_id' => 'required',
            'content' => 'required|min:10|max:500'
        ]);
        $con = conversation::find($request->conversation_id);
        $param = $request->only('conversation_id', 'content', 'sender_id');
        if ($request->sender_id) {
            $param['reciever_id'] = $con->friend()->id;
        } else {
            $param['reciever_id'] = 0;
        }
        $mes = new message();
        $mes->conversation_id = $param['conversation_id'];
        $mes->sender_id = $param['sender_id'];
        $mes->content = $param['content'];
        $mes->reciever_id = $param['reciever_id'];
        $mes->save();
        session()->flash('msg', 'تم ارسال الرسالة ');
        return redirect(url()->previous());
    }

    function block($id) {
        conversation::where('id', $id)->update(['isBlock' => 1]);
        $con = conversation::find($id);
        \App\notifcation::addNew(11, $con->id, $con->sender_id, 'رسالة ادارية', 'تم حظرالمحادثة التابعة لمشروع :' . $con->project->title . ' لمزيد من المعلومات راجع الإدارة.', 0);
        \App\notifcation::addNew(11, $con->id, $con->reciever_id, 'رسالة ادارية', 'تم حظرالمحادثة التابعة لمشروع :' . $con->project->title . ' لمزيد من المعلومات راجع الإدارة.', 0);

        //this new  added by me
        /////////////////////////////////////////////////
        $user1 = \App\user::find($con->sender_id);
        if (!empty($user1->device_token)) {
            $m1 = ['en' => 'تم حظرالمحادثة التابعة لمشروع :' . $con->project->title . ' لمزيد من المعلومات راجع الإدارة.'];
            $url = url('/').'/project/'.$con->project->id.'-'.$con->project->title;
            sendNotification($m1, $user1->device_token, 'message',$url);
        }
        $user2 = \App\user::find($con->reciever_id);
        if (!empty($user2->device_token)) {
            $m2 = ['en' => 'تم حظرالمحادثة التابعة لمشروع :' . $con->project->title . ' لمزيد من المعلومات راجع الإدارة.'];
            $url = url('/').'/project/'.$con->project->id.'-'.$con->project->title;
            sendNotification($m2, $user2->device_token, 'message',$url);
        }
        ///////////////////////////////////////////

        session()->flash('msg', 'تم حظر المحادثة');
        return redirect(redirect()->back()->getTargetUrl());
    }

    function unblock($id) {
        conversation::where('id', $id)->update(['isBlock' => 0]);
        $con = conversation::find($id);
        \App\notifcation::addNew(11, $con->id, $con->sender_id, 'رسالة ادارية', 'تم تفعيل المحادثة التابعة لمشروع :' . $con->project->title . ' لمزيد من المعلومات راجع الإدارة.', 0);
        \App\notifcation::addNew(11, $con->id, $con->reciever_id, 'رسالة ادارية', 'تم تفعيل المحادثة التابعة لمشروع :' . $con->project->title . ' لمزيد من المعلومات راجع الإدارة.', 0);

        //this new  added by me
        /////////////////////////////////////////////////
        $user1 = \App\user::find($con->sender_id);
        if (!empty($user1->device_token)) {
            $m1 = ['en' => 'تم تفعيل المحادثة التابعة لمشروع :' . $con->project->title . ' لمزيد من المعلومات راجع الإدارة.'];
            $url = url('/').'/project/'.$con->project->id.'-'.$con->project->title;
            sendNotification($m1, $user1->device_token, 'message',$url);
        }
        $user2 = \App\user::find($con->reciever_id);
        if (!empty($user2->device_token)) {
            $m2 = ['en' =>'تم تفعيل المحادثة التابعة لمشروع :' . $con->project->title . ' لمزيد من المعلومات راجع الإدارة.'];
            $url = url('/').'/project/'.$con->project->id.'-'.$con->project->title;
            sendNotification($m2, $user2->device_token, 'message',$url);
        }
        ///////////////////////////////////////////
        
        session()->flash('msg', 'تم الغاء حظر المحادثة');
        return redirect(redirect()->back()->getTargetUrl());
    }

}
