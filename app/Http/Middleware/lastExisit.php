<?php

namespace App\Http\Middleware;

use App\message;
use App\notifcation;
use App\setting;
use App\transaction;
use Illuminate\Support\Facades\DB;
use App\user;
use Closure;
use Carbon\Carbon;

class lastExisit {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        global $setting;
        global $templateData;
                        date_default_timezone_set ('Asia/Riyadh');

        // session()->put('login_url',url()->full());
        $setting = setting::siteSettings();

        if (session('user')) {
            
            user::where('id', session('user')['id'])->update(['lastLogin' => date('y-m-d H:i:s')]);
            
            $templateData['messages'] = \App\conversation::whereHas('messages',function($q){
                $q->where('reciever_id', session('user')['id'])
                        ->orWhere('VIPUser', session('user')['id']);
            })->with(['messages','messages.sender'])->orderBy('created_at','desc')->paginate(10);
           
            $unseen = 0;
            foreach ($templateData['messages'] as $value) {
                if (session('user')['isVIP']) {
                    if ($value->messages->last()->VIPSeen===0)
                        $unseen++;
                }else {
                    if (!$value->messages->last()->seen&&$value->messages->last()->reciever_id==session('user')['id'])
                        $unseen++;
                }
            }
            $templateData['unseen'] = $unseen;

            $templateData['notifcations'] = notifcation::where('user_id', session('user')['id'])->latest()->paginate(10);

            $unseen = 0;
            foreach ($templateData['notifcations'] as $value) {
                if (!$value->seen)
                    $unseen++;
            }
            $templateData['unseenNoti'] = $unseen;
            $ses = new \Illuminate\Support\Facades\Session();

            $lastCheck = $ses::get('lastCheck');
            if ($lastCheck) {
                $minuts = Carbon::now()->diffInMinutes($lastCheck);
            } else
                $minuts = 60;

            if (!$lastCheck || $minuts >= 60) {
                $now1 = Carbon::now();

                \Illuminate\Support\Facades\Session::put('lastCheck', $now1);
                $id = \Illuminate\Support\Facades\Session::get('user')['id'];
                $transactions = transaction::where('status', 0)->where('reciever_id', $id)->where('sender_id','<>',0)->where(DB::raw('DATEDIFF(curdate(),created_at)'), '>', $setting['suspended_balance_day'])->get();

                foreach ($transactions as $transaction) {
                    user::where('id', $id)->update(['suspended_balance' => DB::raw('suspended_balance - ' . $transaction->amount_recieve)]);
                    transaction::where('id', $transaction->id)->update(['status' => 1]);
                }
            }

            $user = user::where('isdelete', 0)->find(session('user')['id']);
            if (!$user) {
                session()->flash('msg', 'تم حذف حسابك من قبل الإدارة ,الرجاء التواصل مع الإدارة');
                session()->forget('user');
            } else {
                $setting['isBlock'] = ($user->status == 2) ? 1 : 0;
            }
          $segment=request()->segment(1);
          if(!checkType($segment)){
            return redirect('/editProfile');
        }
        }

        return $next($request);
    }

    public function terminate($request, $response) {
        // Store the session data...
    }

}
