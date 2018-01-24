<?php

namespace App\Http\Controllers\admin;

use App\Services\Auth;
use App\Services\Encrypt;
use App\setting;
use App\admin;
use App\link;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class adminAuth extends Controller {

    //

    function login() {
        return view('admin.auth.login');
    }

    function notAuth() {

        return view('admin.notAuth');
    }

    function accountSettingPost(Request $request) {
        $this->validate($request, [
            'password' => 'required|min:5|confirmed',
            'password_confirmation' => 'required'
        ]);

        $encrypt = new Encrypt();
        $salt = $encrypt->genRndSalt(10);
        $pass = $encrypt->encryptUserPwd($request['password'], $salt);
        Admin::where('id', session('admin')['id'])
                    ->update(['password' => $pass,'salt'=>$salt]);
        session()->flash('msg', 'تم تغير كلمة المرور ');
        return redirect()->back();
    }

    function accountSetting() {
        return view('admin/auth/accountSetting');
    }

    function resetPass($code = '') {
        $l = Link::where('code', $code)->where('status', 0)->count();
        if ($l) {
            return view('admin.auth.resetPass', array('code' => $code));
        } else {
            session()->flash('msg', 'خطأ في الرابط');
            return redirect('admin/login');
        }
    }

    function handel_login(Request $request) {

        $this->validate($request, [
            'email' => 'required|exists:admin,email|email',
            'password' => 'required'
        ]);

        $data = [];
        $data['email'] = $request['email'];
        $data['password'] = $request['password'];
        $auth = new Auth();
        $ret = $auth->process_login($data);
        if ($ret == "errors") {
            session()->flash('msg', "خطأ في اسم المستخدم وكلمة المرور");
            return redirect('admin/login');
        } else if ($ret == "notActive") {
            session()->flash('msg', "حسابك غير مفعل تواصل مع الإدارة ");
            return redirect('admin/login');
        } else {
            return redirect('/admin/users/index');
        }
    }

    function forget() {
        return view('admin.auth.forget');
    }

    function handle_Forget(Request $request) {
        $this->validate($request, [
            'email' => 'required|exists:admin,email|email',
        ]);

        $token = link::add($request['email'], 4);

        session()->flash('msg', 'تفقد بريدك الإلكتروني لإعادة تعين كلمة المرور');
        return redirect('admin/forget');
    }

    function logout() {
        session()->forget('admin');
        session()->forget('menu');
        session()->forget('scope');
        return redirect('admin/login');
    }

    function handle_resetPass(Request $request) {
        $this->validate($request, [
            'password' => 'required|min:5|confirmed',
            'password_confirmation' => 'required'
        ]);


        $l = Link::where('token', $request['token'])->where('status', 0);
        $link = $l->get();
        if (!$link->isEmpty()) {
            $encrypt = new Encrypt();
            $salt = $encrypt->genRndSalt(10);
            $pass = $encrypt->encryptUserPwd($request['password'], $salt);
            Admin::where('id', $link->first()->id)
                    ->update(['password' => $pass,'salt'=>$salt]);
            $l->update(['status' => 1]);
            session()->flash('msg', 'تم تغير كلمة المرور الرجاء تسجيل الدخول');
            return redirect('admin/login');
        } else {
            Link::where('token', $request['token'])->get();
            if (!$link->isEmpty()) {
                session()->flash('msg', 'لقد تم استخدام هذا الرابط من قبل');
            } else {
                session()->flash('msg', 'هناك خطأ في الرابط المستخدم');
            }
            return redirect('admin/forget');
        }
    }
    
    

}
