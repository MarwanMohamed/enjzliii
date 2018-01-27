<?php
namespace App\Services;

use App\controller;
use App\passenger;
use App\Provider;
use App\Services\Encrypt;
use App\admin;
use App\Setting;
use Carbon\Carbon;

class Auth {
    private $Encrypt;
    function __construct(){
        $this->Encrypt = new Encrypt();
    }

    function process_login($login_array_input = NULL){
        if(!isset($login_array_input) OR count($login_array_input) != 2)
            return false;
        //set its variable
        $in_user_email = $login_array_input['email'];
        $in_user_pass = $login_array_input['password'];
        $user = admin::where('email', $in_user_email)->first();
        $user_id = $user->id;
        $user_pass = $user->password;
        $user_salt = $user->salt;

        if($this->Encrypt->encryptUserPwd( $in_user_pass,$user_salt ) === $user_pass){
            if(!$user->active){
                return 'notActive';
            }
            $scope=Admin::havePermission($user->id);
            $group_id=$user->permission_group;
            $menu=controller::orderBy('order','asc')->whereHas('permission',function($q) use ($group_id){
                $q->where('PermissionGroup_id',$group_id);
            })->with('fun')->get()->toArray();

            session(['admin' => $user,'scope'=>$scope,'menu'=>$menu]);
            return true;
        }else{
            return 'errors';
        }
    }
    
    function checkPassword($password){
        $user = Admin::where('id',session()->get('admin')->id )->first();
        $user_id = $user->id;
        $user_pass = $user->password;
        $user_salt = $user->salt;
//        dd($this->Encrypt->encryptUserPwd( $password,$user_salt ) );

        if($this->Encrypt->encryptUserPwd( $password,$user_salt ) === $user_pass){
            return true;
        }else{
            return false;
        }

    }

    function api_login($login_array_input = NULL){
        if(!isset($login_array_input) OR count($login_array_input) != 2)
            return false;
        //set its variable
        $in_user_email = $login_array_input['email'];
        $in_user_pass = $login_array_input['password'];
//        if()
//
        $user = provider::where('email', $in_user_email)->first();
        if(sizeof($user)){
            $user_type=1;
        }else{
            $user = passenger::where('email', $in_user_email)->first();
            if(sizeof($user)){
                $user_type=2;
            }else{
                $user_type=0;
            }
        }
        $json['status']=0;

        if($user_type) {
            $user_pass = $user->password;
            $user_salt = $user->salt;
            $json['status']=0;
            if ($this->Encrypt->encryptUserPwd($in_user_pass, $user_salt) === $user_pass) {
                 if(!$user->emailConfirm) {
                    $json['msg']= trans('lang.confirmEmail');
                }else if (!$user->activate) {
                    $json['msg']= trans('lang.notActive');
                }else if($user->block){
                     $json['msg']= trans('lang.block');
                 }
                else {
                    $token=sha1($this->generateRandomString(30));
                    if($user_type==1)
                        provider::where('email',$in_user_email)->update(['token'=>$token]);
                    else
                        passenger::where('email',$in_user_email)->update(['token'=>$token]);
                    $json =
                        ['msg'=>trans('lang.access_granted'),
                         'token'=>$token,
                         'userType'=>$user_type,
                         'status'=>1
                        ];
                }
            } else {
                $json['msg']= trans('lang.auth_error');
            }
        }else{
            $json['msg']= trans('lang.auth_error');
        }

        return $json;
    }


    function api_register($request = NULL){

        //set its variable
        $in_user_email = $request['email'];
        $in_user_pass = $request['password'];
        $user_type = $request['user_type'];
        $user_phone = $request['phone'];
        $user_fullname = $request['username'];
        if(($user_type==1&&isset($request['airport_id']))||$user_type!=1) {

            if ($user_type == 1) {
                $user = new provider();
                $user->airport_id=$request['airport_id'];

            } else {
                $user = new passenger();
                $user->activate = 1;
            }
            $salt = $this->generateRandomString(6);
            $emailCode = sha1($this->generateRandomString(5, 'int'));

            $user->email = $in_user_email;
            $user->salt = $salt;
            $user->emailCode = $emailCode;
            $user->phone = $user_phone;
            $user->username = $user_fullname;
            $user->avatar = 'avatar.jpg';
            $user->password = $this->Encrypt->encryptUserPwd($in_user_pass, $salt);
            $user->save();
            $json['status'] = 1;
            $json['msg'] = trans('lang.registerd');
            //        $json['emailCode']=$emailCode;
            $setting = Setting::siteSettings(['site_name', 'site_title', 'copyright']);
            \Illuminate\Support\Facades\Mail
                ::to($request['email'])->send
                (new \App\Mail\ConfirmEmail($emailCode, $setting['site_name'], $setting['site_title'], $setting['copyright']));

        }else{
            $json=[
                'status' => 0,
                'msg'      => trans('lang.validation'),
                'errors'       => 'missing airport_id'
            ];
        }
        return $json;
    }

    function generateRandomString($length = 10,$type='alpha') {
        switch ($type) {
            case 'alpha':
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                break;
            case 'int':
                $characters = '0123456789';
                break;
            default :
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }

                $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }


}




