<?php

namespace App\Http\Controllers\api;

use App\Logic\Password;
use App\user;
use App\link;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use App\Services\Encrypt;
use File;
use Response;
use Validator;
use Laravel\Socialite\Facades\Socialite;

class users extends Controller
{

    //

    function registration(Request $request)
    {
        global $setting;
        if (!$setting['users_isClose']) {

            $message = ['email.unique' => 'البريد الإلكتروني مسجل مسبقا'];
            $validator = Validator::make($request->all(), [
                'email' => 'required|max:250|email|unique:user,email',
                'password' => 'required|min:5|max:500',
//                         'password_confirmation' => 'required|min:5|max:500',
                'fname' => 'required|min:3|max:250',
                'lname' => 'required|min:3|max:250',
//                         'mobile' => 'required|min:5|max:250',
//                         'mobile_country_id' => 'required',
//                         'country_id' => 'required',
            ], $message);

            if ($validator->fails()) {
                $json['errors'] = $validator->errors();
                $json['status'] = 0;
            } else {
                $usercheck = user::where('mobile', $request->mobile)->where('mobile_country_id', $request->mobile_country_id)->first();

                if (!$usercheck) {
                    $user = new user();
                    $user->fname = $request['fname'];
                    $user->lname = $request['lname'];
//                     $user->mobile = $request['mobile'];
//                     $user->mobile_country_id = $request['mobile_country_id'];
//                     $user->country_id = $request['country_id'];
                    $user->email = $request['email'];

                    $encript = new Encrypt();
                    $salt = $encript->genRndSalt();
                    $password = $encript->encryptUserPwd($request['password'], $salt);
                    $user->salt = $salt;
                    $user->password = $password;
                    $user->save();
                    $user->addDefaultNoti();
                    $token = link::add($request['email'], 1);
                    $json['message'] = 'تم انشاء حسابك بنجاح,ستصلك رسالة الي بريدك الإلكتروني لتفعيله';
                } else {
                    $json['msg'] = "رقم الجوال الذي ادخلته مستخدم";
                }
            }
        } else {
            $json['msg'] = 'تم ايقاف التسجيل مؤقتا';
        }
        return response()->json($json);
    }

    public function socialLoginHandle(Request $request)
    {
        $messages = [
            'token.required' => 'الرجاء التأكد من ادخل التوكين.',
            'type.required' => 'الرجاء التأكد من ادخل نوع تسجيل الدخول',
            'string' => 'صيغة البيانات المدخلة غير صحيحة',
        ];
//        dd($request->all());

        $validator = Validator::make($request->all(), [
            'token' => 'required|string',
            'type' => 'required|string',
            'token_secret' => 'required_if:type,twitter|string',
        ], $messages);

        if ($validator->fails()) {
            return response()->make([
                'message' => 'حدث خطأ ما.',
                'errors' => $validator->errors()
            ], 422);
        }
        if ($request['type'] == 'facebook') {
            return $this->facebookLogin($request['token']);
        } else if ($request['type'] == 'twitter') {
            return $this->twitterLogin($request['token'], $request['token_secret']);
        } else if ($request['type'] == 'google') {
            return $this->googleLogin($request['token']);
        } else {
            $jresult['status'] = 'false';
            $jresult['message'] = 'النوع غير مدعوم';
            return $jresult;
        }
    }

    private function facebookLogin($token)
    {

        try {
            $providerUser = Socialite::driver('facebook')->stateless()->userFromToken($token);

            $user = \App\User::where('email', $providerUser->getId() . '@facebook.com')->first();
            if ($user == null) {
                $encrypt_pass = Password::hash(mt_rand());

                $user = new \App\User;
                $user->name = $providerUser->getName();
                $user->email = $providerUser->getId() . '@facebook.com';
//                $user->u_avatar = $providerUser->getAvatar();
                $user->password = $encrypt_pass;
                $user->username = '';
//                $user->status = 1;
                $user->api_token = md5(uniqid(rand(), TRUE));
                $user->save();
                $jresult['status'] = 1;
                $jresult['message'] = 'تم تسجيل الدخول.';
                $jresult['user'] = $user;
            } else {

                if ($user->status != 1) {
                    $message = 'تم حذر حسابك, راجع الادارة لمزيد من التفاصيل';
                    $jresult['status'] = 'false';
                    $jresult['message'] = $message;
                }
                $user->api_token = md5(uniqid(rand(), TRUE));
                $user->save();

                $jresult['status'] = 'true';
                $jresult['message'] = 'تم تسجيل الدخول.';
                $jresult['user'] = $user;
            }
        } catch (\Exception $e) {

            $message = 'حدث خطأ ما,, الرجاء المحاولة مرة اخرى';
            $jresult['status'] = 'false';
            $jresult['message'] = $message;
            return response()->json($jresult, 400);
        }
        return response()->json($jresult);
    }

    private function twitterLogin($token, $token_secret)
    {
        try {
            $providerUser = Socialite::driver('twitter')->userFromTokenAndSecret($token, $token_secret);
            $user = \App\User::where('email', $providerUser->getId() . '@twitter.com')->first();
            if ($user == null) {
                $encrypt_pass = Password::hash(mt_rand());

                $user = new \App\User;
                $user->name = $providerUser->getName();
                $user->email = $providerUser->getId() . '@twitter.com';
//                $user->u_avatar = $providerUser->getAvatar();
                $user->password = $encrypt_pass;

                $user->status = 1;
                $user->api_token = md5(uniqid(rand(), TRUE));
                $user->save();
                $jresult['status'] = 1;
                $jresult['message'] = 'تم تسجيل الدخول.';
                $jresult['user'] = $user;
            } else {
                if ($user->status != 1) {
                    $message = 'تم حظر حسابك, راجع الادارة لمزيد من التفاصيل';
                    $jresult['status'] = 'false';
                    $jresult['message'] = $message;
                }

                $user->api_token = md5(uniqid(rand(), TRUE));
                $user->save();

                $jresult['status'] = 'true';
                $jresult['message'] = 'تم تسجيل الدخول.';
                $jresult['user'] = $user;
            }
        } catch (\Exception $e) {
            dd($e->getMessage());

            $message = 'حدث خطأ ما,, الرجاء المحاولة مرة اخرى';
            $jresult['status'] = 'false';
            $jresult['message'] = $message;
        }
        return response()->json($jresult);
    }

    function pushToken(Request $request){
        if(empty($request->user_id)) { return response(['error'=>'رقم المستخدم حقل مطلوب'], 422);}
        $user = \App\user::find($request->user_id);
        if($user) {
            $device_token = $request->device_token;
            if (!empty($device_token)) {
                user::where('id', $request->user_id)->update(['device_token' =>$device_token]);
                return response(['message'=>'تمت العملية بنجاح'], 200);
            }
            return response(['error'=>'الرجاء دراج التوكن'], 422);
        }
        return response(['error'=>'رقم المستخدم غير صحيح'], 422);
    }
    function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|max:250',
            'password' => 'required|min:5|max:500',
        ]);
        if ($validator->fails()) {
            return response()->json([
                "error" => "Validation Errors",
                'error' => $validator->errors()
            ], 422);
        }


        $user = user::where('email', $request->email)->where('isdelete', 0)->first();


        if ($user) {
            if ($user->checkPass($request['password'])) {
                if ($user->emailConfirm) {
                    if ($user->status != 2) {
                        // The passwords match...

                        $json['id'] = $user->id;
                        if(empty($user->api_token)){
                            $json['api_token'] = md5(microtime() . rand());
                            user::where('email', $request->email)->update(['lastLogin' => date('Y-m-d H:i:s'), 'api_token' => $json['api_token']]);
                        }else{
                            $json['api_token'] = $user->api_token;
                        }
                        $json['status'] = 1;
                        $json['name'] = $user->fname . ' ' . $user->lname;
                        $path = route('avatar', ['user' => $user->avatar ?: 'image_avatar.png']);
                        $path = (strpos($path , 'graph.facebook.com') > 0)? str_replace(url('api/v1/avatar/').'/', '' , $path) : $path;
                        $json['image'] = $path;
                        $json['location'] = $user->city;

                        return response()->json($json);
                    } else {
                        $json['msg'] = 'هذاا الحساب محظور الرجاء التواصل مع الإدارة لمعرفة الأسباب';
                        return response($json, 401);

                    }
                } else {
                    $json['msg'] = 'حسابك غير مفعل ,تفقد بريدك الإلكتروني لتفعيل حسابك';
                    return response($json, 401);
                }
            } else
                return response(['msg' => 'خطأ في اسم المستخدم او كلمة المرور'], 401);
        } else
            return response(['msg' => 'خطأ في اسم المستخدم او كلمة المرور'], 401);
    }

    public function showImage($avatar)
    {
        $path = storage_path('app/uploads/images' . $avatar);

        if (!file_exists($path) || empty($avatar)) {
            $path = storage_path('app/uploads/images/image_avatar.png');
        }
        return $this->makeImage($path);
    }

    private function makeImage($path)
    {
        if (!File::exists($path)) {
            abort(404);
        }
        $file = File::get($path);
        $type = File::mimeType($path);
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }

}
