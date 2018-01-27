<?php

namespace App\Http\Controllers;

use App\bid;
use App\conversation;
use App\evaluate;
use App\favorite;
use App\file;
use App\like;
use App\link;
use App\Logic\FileRepository;
use App\Logic\ImageRepository;
use App\message;
use App\notifcation;
use App\portfolio;
use App\project;
use App\contact;
use App\EditPrice;
use App\projectDescussion;
use App\projectFreelancer;
use App\projectskills;
use App\report;
use App\Services\Encrypt;
use App\transaction;
use App\user;
use App\userSkills;
use App\view;
use App\withdrawRequest;
use App\caneclProject;
use App\VIPRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Monolog\Handler\IFTTTHandler;
use Validator;
use Socialite;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\Storage;

class handleController extends Controller
{

    //


    function sendActivaeMobile(Request $request)
    {
        $this->validate($request, [
            'mobile_country_id' => 'required|exists:country,id',
            'mobile' => 'required|integer|min:5',
        ]);


        $code = rand(0, 99999);
        $param['mobile'] = $request->mobile;
        $param['mobile_country_id'] = $request->mobile_country_id;
        $param['mobile_code'] = $code;
        user::where('id', session('user')['id'])->update($param);
        $country = \App\country::find($request->mobile_country_id);
        $mobile = '+' . $country->zipCode . $request->mobile;
        $json = sendSMS($mobile, 'كود التفعيل على موقع انجزلي : ' . $code);
        return response($json);
    }


    function checkMobileCode(Request $request)
    {
        $this->validate($request, [
            'code' => 'required|',
        ]);

        $user = user::where('id', session('user')['id'])->where('mobile_code', $request->code)->first();
        if ($user) {
            user::where('id', session('user')['id'])->update(['mobile_code' => '', 'mobileConfirm' => 1]);


            $step = json_decode(session('user')['finishProfileStep']);
            if (!isset($step->mobileConfirm)) {
                $step->mobileConfirm = 1;
                $param['finishProfileStep'] = json_encode($step);
            }
            user::where('id', session('user')['id'])->update($param);


            return response(['status' => 1]);
        } else {
            return response(['status' => 0, 'msg' => 'تحقق من الكود']);
        }

    }

    function sendVIP(Request $request)
    {
        $this->validate($request, [
            'fullname' => 'required|min:5|max:100',
            'email' => 'required|email|min:5|max:100',
            'specialization_id' => 'required|exists:specialization,id',
            'budget_id' => 'required|exists:projectbudget,id',
            'details' => 'required|min:25|max:5000',
        ]);


        $vipRequest = VIPRequest::where('email', $request->email)->where('status', 0)->first();
        if ($vipRequest) {
            session()->flash('error', 'لقد استقبلنا طلبك من قبل , سيتم التواصل معك من قبل مدير super');
        } else {
            $vipRequest = new VIPRequest();
            $vipRequest->fullname = $request->fullname;
            $vipRequest->email = $request->email;
            $vipRequest->specialization_id = $request->specialization_id;
            $vipRequest->budget_id = $request->budget_id;
            $vipRequest->details = $request->details;
            $vipRequest->save();
            session()->flash('msg', 'تم ارسال طلبك سيتم التواصل معك من قبل مدير super');
        }


        return redirect()->back();
    }

    function inviteFreelancer($project_id, $freelancer_id)
    {
        $project = project::where('projectOwner_id', session('user')['id'])->orWhere('VIPUser', session('user')['id'])->find($project_id);
        $project1 = project::find($project_id);

        if ($project && $project1->status == 2) {
            $user = user::find($freelancer_id);
            if ($user) {
                $details = 'تم دعوتك لاضافة عرض على :' . $project1->title;
                $noti = notifcation::where('type', 2)->where('type_id', $project_id)->where('user_id', $freelancer_id)->first();

                //this new  added by me
                /////////////////////////////////////////////////
          
                if (!empty($user->device_token)) {
                    $m1 = ['en' => 'تم دعوتك لاضافة عرض على : ' . $project1->title . ' من قبل الإدارة '];
                    $url = url('/').'/project/'.$project1->id.'-'.$project1->title;
                    sendNotification($m1, $user->device_token, 'project',$url);
                }
                /////////////////////////////////////////////////
                if (!$noti || 1) {
                    notifcation::addNew(2, $project_id, $freelancer_id, 'دعوة لمشروع', $details, session('user')['id']);
                    $json['status'] = 1;
                    $json['msg'] = 'تم دعوة ' . $user->fullname();
                } else {
                    $json['status'] = 0;
                    $json['msg'] = 'تم دعوة ' . $user->fullname() . ' من قبل';
                }
            } else {
                $json['status'] = 0;
                $json['msg'] = 'خطا في اسم المسخدم';
            }
        } else {
            $json['status'] = 0;
            $json['msg'] = 'خطأ في المشروع';
        }

        if (request()->ajax()) {
            return response()->json($json);
        } else {
            session()->flash('msg', $json['msg']);
            return redirect('freelancer/' . $project_id);
        }
    }

    function cancelFreelancer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reason' => 'required|min:10|max:2000',
            'project_id' => 'required|integer',
            'freelancer_id' => 'required|integer',
        ]);


        if ($validator->fails()) {
            $json['msg'] = $validator->errors()->all();
            $json['status'] = 0;
        } else {
            $cancel = caneclProject::where('project_id', $request->project_id)->where('freelancer_id', $request->freelancer_id)->first();
            if (!$cancel) {
                $project = project::find($request->project_id);
                $project->update(['isView' => 0]);
                if ($project && (!$project->isBlock)) {
                    $cancel = new caneclProject();
                    $cancel->project_id = $request->project_id;
                    $cancel->reason = $request->reason;
                    $cancel->freelancer_id = $request->freelancer_id;
                    $cancel->save();
                    \App\project::where('id',$request->project_id)->update(['status'=>4]);
                    $offers = \App\bid::where('project_id', $request->project_id)->get();
                    foreach ($offers as $offer) {
                        $offer = \App\bid::find($offer->id);
                        $offer->status = 4;
                        $offer->save();
                    }
                    $json['status'] = 1;
                    $json['msg'] = 'لقد تم استقبال طلبك من قبل الادارة سيتم الرد عليك خلال 24 ساعة';


                    notifcation::addNew(12, $project->id, $request->freelancer_id, 'الغاء المشروع', 'تم الغاء المشروع من قبل صاحبه:  ' . $project->title , 0);

                    $freelancer = \App\User::find($request->freelancer_id);

                    \Illuminate\Support\Facades\Mail::to($freelancer->email)
                    ->send(new \App\Mail\SendMessage('تم طلب الغاء المشروع من قبل صاحبه', 'انجزلى', $project->title, 'انجزلى'));


                } else {
                    $json['status'] = 0;
                    $json['msg'] = 'هذا المشروع محظور';
                }
            } else {
                $json['status'] = 0;
                $json['msg'] = 'لقد تم تقديم طلب الغاء المشروع من قبل سيتم التواصل معك خلال 24 ساعة';
            }
        }
        if ($request->ajax())
            return response()->json($json);
        else {
            session()->flash('msg', $json['msg']);
            return redirect('/project/' . $request->project_id);
        }
    }

    function Contact(Request $request)
    {

        $secret = '6LcC-DEUAAAAADOdA-ypRQbBRmR_0o-WdLbfwtMW';
        $response = $request['g-recaptcha-response'];
        $remoteip = $_SERVER['REMOTE_ADDR'];

        $result = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$remoteip");
        $resjson = json_decode($result, true);
        if(!$resjson['success']){
            $json['msg'] = 'الرجاء التأكد من التحقق البشري';
            $json['status'] = 0;
            if ($request->ajax()) {
                return response()->json($json);
            }
        }
        $validator = Validator::make($request->all(), [
            'email' => 'required|max:250',
            'title' => 'required|min:5|max:500',
            'problem_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            $json['msg'] = $validator->errors()->all();
            $json['status'] = 0;
        } else {
            $response = check_recaptcha($request['g-recaptcha-response']);
            if ($response | 1) {
                $contact = new contact();
                $contact->email = $request->email;
                $contact->title = $request->title;
                $contact->problem_id = $request->problem_id;
                $contact->message = $request->message;
                $contact->save();
                global $setting;
                $problem = \App\tibs::where('id', $request->problem_id)->first()->value;
                \Illuminate\Support\Facades\Mail::to($setting['contact_email'])
                    ->send(new \App\Mail\contact($request->email, $problem, $request->title, $request->message, ''));
                $json['status'] = 1;
                $json['msg'] = 'تم استقبال رسالتك';
            } else {
                $json['status'] = 0;
                $json['msg'] = 'الرجاء التأكد من التحقق البشري';
            }
        }
        if ($request->ajax())
            return response()->json($json);
        else
            session()->flash('msg', $json['msg']);
        return redirect('/contact');
    }

    function handleLogin(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('login');
        }
        $validator = Validator::make($request->all(), [
            'email' => 'required|max:250',
            'password' => 'required|min:5|max:500',
        ]);

        if ($validator->fails()) {
            $json['msg'] = $validator->errors()->all();
        } else {
            if (!$request->ajax()) {
                return redirect('/login');
            }
            $users = user::where(function ($q) use ($request) {
                $q->where('email', $request->email)->orWhere('mobile', $request->email);
            })->where('isdelete', 0)->get();
            $user;
            $userNO = 0;
            foreach ($users as $val) {
                if ($val->checkPass($request['password'])) {
                    $userNO++;
                    $user = $val;
                }
            }

            $json['status'] = 0;
            if ($userNO == 0) {
                $json['msg'] = 'خطأ في كلمة المرور';
                return response($json);
            } else if ($userNO > 1) {
                $json['msg'] = 'الرجاء اختار الدولة';
                $json['status'] = 2;
                return response($json);
            }
            if ($user) {
                if ($user->checkPass($request['password'])) {
                    if ($user->emailConfirm) {
                        if ($user->status != 2) {
                            $json['status'] = 1;
                            $json['isFinishProfile'] = $user->isFinishProfile;
                            user::where('email', $request->email)->update(['lastLogin' => date('Y-m-d H:i:s')]);
                            session(['user' => $user->toArray()]);
                            return redirect()->back();
                        } else {
                            $json['msg'] = 'هذاا الحساب محظور الرجاء التواصل مع الإدارة لمعرفة الأسباب';
                        }
                    } else {
                        $json['msg'] = 'حسابك غير مفعل ,تفقد بريدك الإلكتروني لتفعيل حسابك';
                    }
                } else {
                    $json['msg'] = 'خطأ في كلمة المرور';
                }
            } else {
                $json['msg'] = 'خطأ في البريد الإلكتروني';
            }
        }
        return response()->json($json);
    }

    function logout()
    {
        session()->forget('user');
        return redirect('login');
    }

    function handleRegister(Request $request)
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
                $json['msg'] = $validator->errors()->all();
                $json['status'] = 0;
            } else {
                $usercheck = user::where('mobile', $request->mobile)->where('mobile_country_id', $request->mobile_country_id)->first();

                if (!$usercheck) {
                    $json['status'] = 1;
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
                    $user->gender = 1;
                    $user->save();
                    $user->addDefaultNoti();
                    $token = link::add($request['email'], 1);
                    session()->flash('msg', 'تم انشاء حسابك بنجاح,ستصلك رسالة الي بريدك الإلكتروني لتفعيله');
                } else {
                    $json['msg'] = "رقم الجوال الذي ادخلته مستخدم";
                    $json['status'] = 0;
                }
            }
        } else {
            $json['status'] = 0;
            $json['msg'] = 'تم ايقاف التسجيل مؤقتا';
        }
        return response()->json($json);
    }

    function confirmEmail($token)
    {

        $tokenObj = link::where('token', $token)->where('status', '<>', 2)->first();
        if ($tokenObj) {
            if ($tokenObj->status != 2) {
                switch ($tokenObj->type) {
                    case 1 :
                        $email = $tokenObj->email;
                        $steps['emailConfirm'] = 1;
                        $check = \App\user::where('new_email', $email)->first();
                        if($check){
                            user::where('new_email', $email)->update(['new_email'=>null,'email'=>$email,'emailConfirm' => 1, 'finishProfileStep' => json_encode($steps)]);
                        }else{
                            user::where('email', $email)->update(['email'=>$email,'emailConfirm' => 1, 'finishProfileStep' => json_encode($steps)]);

                        }
                        link::where('id', $tokenObj->id)->update(['status' => 2]);
                        session()->forget('user');
                        session()->flash('msg', 'تم تفعيل البريد الالكترونى بنجاح يرجى تسجيل الدخول باستخدامه');
                        return redirect('login');
                        break;

                    case 2:

                        break;
                    case 3:
                        $data['token'] = $token;
                        return view('front.resetPassword', $data);
                        break;
                    case 5:
                        $data['token'] = $token;
                        return view('front.resetPassword', $data);
                        break;
                    case 6:
                        $data['token'] = $token;
                        return view('front.resetPassword', $data);
                        break;

                    case 4:
                        $data['token'] = $token;
                        return view('admin.auth.resetPass', $data);
                        break;
                }
            } else {
                session()->flash('msg', 'الرابط الذي تحاول الوصول اليه غير موجود');
                return redirect('/login');
            }
        } else {
            session()->flash('msg', 'الرابط المستخدم قديم او غير صالح');
            return redirect('error');
        }
    }

    function handleForgetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|max:250|email|exists:user,email',
        ]);

        if ($validator->fails()) {
            $json['msg'] = $validator->errors()->all();
            $json['status'] = 0;
        } else {
            $token = link::add($request['email'], 3);
            $json['status'] = 1;
        }
        return response()->json($json);
    }

    function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:5|max:500|confirmed',
            'password_confirmation' => 'required|min:5|max:500',
        ]);

        $link = link::where('token', $request->token)->where(function ($q) {
            $q->where('type', 3)->orWhere('type', 5)->orWhere('type', 6);
        })->first();
        if ($link) {
            $user = user::where('email', $link->email)->first();
            if ($user) {
                if ($user->updatePassword($request->password)) {
                    $json['status'] = 1;
                    $json['msg'] = 'تم اعاة تعين كلمة المرور';
                    session(['user' => $user->toArray()]);
                    link::where('id', $link->id)->delete();
                } else {
                    $json['status'] = 0;
                    $json['msg'] = 'حصل خطأ ما الرجاء المحاولة مرة أخرى';
                }
            } else {
                $json['status'] = 0;
                $json['msg'] = 'حصل خطأ ما الرجاء المحاولة مرة أخرى';
            }
        } else {
            $json['status'] = 0;
            $json['msg'] = 'خطأ في الرابط';
        }
        return response()->json($json);
    }

    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('facebook')->user();

        // $user->token;
    }

    function uploadImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|image',
        ]);

        if ($validator->fails()) {
            $json = [
                'status' => 0,
                'msg' => $validator->errors()->all()
            ];
        } else {
            $image = new ImageRepository();
            $json = $image->upload($request);
            user::where('id', session('user')['id'])->update(['avatar' => $json['filename']]);
            $user = session('user');
            $user['avatar'] = $json['filename'];
            session()->put('user', $user);
        }

        return response()->json($json);
    }

//    upload image

    function upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required',
        ]);

        if ($validator->fails()) {
            $json = [
                'status' => 0,
                'msg' => $validator->errors()->all()
            ];
        } else {
            $file = new FileRepository();
            $json = $file->upload($request);
//            $user_id = session('user')['id'];
//           \App\portfolio::where('user_id', $user_id)->first(['files'])->files;

//            $filesIds = \App\portfolio::where('user_id', 42)->first(['files'])->files;
//            $divideIds = explode('"',$filesIds);
//            $arr = [];
//            foreach ($divideIds as $id){
//                if(is_numeric($id)){
//                    array_push($arr,$id);
//                }
//            }
//            array_push($arr,$json['file_id']);

//            \App\portfolio::where('user_id', $user_id)->update(['files'=>json_encode($arr)]);
        }
        return response()->json($json);
    }

    function uploadAddProject(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimetypes:' . $setting['addProjectFiles'],
        ]);

        if ($validator->fails()) {
            $json = [
                'status' => 0,
                'msg' => $validator->errors()->all()
            ];
        } else {
            $file = new FileRepository();
            $json = $file->upload($request);
        }
        return response()->json($json);
    }

    function uploadFile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required',
        ]);
        if ($validator->fails()) {
            $json = [
                'status' => 0,
                'msg' => $validator->errors()->all()
            ];
        } else {
            $file = new FileRepository();
            $json['filenames'] = $file->multiple_upload();
            $json['status'] = 1;
        }
        return response()->json($json);
    }

    function uploadFileMultiple(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required',
        ]);
        if ($validator->fails()) {
            $json = [
                'status' => 0,
                'msg' => $validator->errors()->all()
            ];
        } else {
            $file = new FileRepository();
            $json['filenames'] = $file->multiple_upload_IF();
            $json['status'] = 1;
        }
        return response()->json($json);
    }

    function checkUserName($username)
    {
        $validator = Validator::make(['username' => $username], [
            'username' => 'required|min:4|regex:/^[0-9a-zA-Z_]+$/|unique:user,username,' . session('user')['id']
        ]);
        if ($validator->fails()) {
            $json = [
                'status' => 0,
                'msg' => $validator->errors()->all()
            ];
        } else {
            $json = [
                'status' => 1];
        }
        return response()->json($json);
    }

    function handleEditProfile(Request $request)
    { 
       $type1 = $request->type1;
       $type2 = $request->type2;
        if(empty($type1) && empty($type2)){
            $json = [
                'status' => 0,
                'msg' => 'يجب اختيار نوع حساب واحد على الاقل'

            ];
            return response()->json($json);
        }

        $rule = [
            'fname' => 'required|min:3|max:250',
            'lname' => 'required|max:250',
            'new_email' => 'required|min:3|max:250|email',
            'country_id' => 'required',
            'mobile' => 'required|numeric|min:0',
            'day' => 'required',
            'gender' => 'required',
            'month' => 'required',
            'year' => 'required',
            'specialization_id' => 'required',
            'skills' => 'required',
            'newPassword' => 'confirmed|max:250',
            'newPassword_confirmation' => '',
            'Brief' => 'required|max:1000|min:50',
        ];

        if (!session('user')['username'])
            $rule['username'] = 'required|min:4|regex:/^[0-9a-zA-Z_]+$/|unique:user,username,' . session('user')['id'];
        $validator = Validator::make($request->all(), $rule, ['country_id.required' => 'الرجاء اختيار الدولة']);

        if ($validator->fails()) {
            $json = [
                'status' => 0,
                'msg' => $validator->errors()->all()
            ];
        } else {
            $user = user::where('email', $request->email)->where('id', '<>', session('user')['id'])->first();
            if ($user) {
                $json = [
                    'status' => 0,
                    'msg' => 'البريد الإلكتروني الذي اخترته محجوز لمستخدم آخر'
                ];
            } else {

                $mobile = user::where('mobile', $request->mobile)->where('country_id', $request->country_id)->where('id', '<>', session('user')['id'])->first();
                if ($mobile) {
                    $json = [
                        'status' => 0,
                        'msg' => 'رقم الجوال الذي اخترته مسجل لحساب اخر'
                    ];
                    return response($json);
                }
                $param = $request->only(['fname', 'Brief', 'mobile', 'lname','new_email', 'country_id', 'city', 'specialization_id','gender']);
                if (!session('user')['username'])
                    $param['username'] = $request->username;
                    
                $date_of_birth = Carbon::createFromDate($request['year'], $request['month'], $request['day']);
                $usr = user::find(session('user')['id']);
                
                if (!empty($usr->DOB)) {
                    
                    if (Carbon::parse($usr->DOB)->toDateString() != $date_of_birth->toDateString()){
                        $json = [
                        'status' => 0,
                        'msg' => 'تحذير لا يمكنك تغيير تاريخ الميلاد لانه مرتبط بمعاملات ماليه  قد يؤدي ذلك الي مسائله قانونيه'
                        ];
                        return response($json);
                    }
                    
                }else if(Carbon::now()->diffInYears($date_of_birth) < 18 ) {
                     $json = [
                        'status' => 0,
                        'msg' => 'يجب على الحقل تاريخ الميلاد أن يكون 18 سنة فما فوق.'
                    ];
                    return response($json);
                    
                }else{
                    
                    $param['DOB'] = $date_of_birth;
                }
                userSkills::updateSkills(session('user')['id'], $request['skills']);
                $param['type'] = 1;
                if (isset($request['type1']) && isset($request['type2'])) {
                    $param['type'] = 3;
                } else if (isset($request['type2'])) {
                    $param['type'] = 2;
                }
                $user = user::find(session('user')['id']);
                if ($request['currentPassword']) {
                    if ($user->checkPass($request['currentPassword'])) {
                        $encript = new Encrypt();
                        $salt = $encript->genRndSalt();
                        $password = $encript->encryptUserPwd($request['newPassword'], $salt);
                        $param['salt'] = $salt;
                        $param['password'] = $password;
                        $param['gender'] = $request['gender'];
                        $check = user::where('id', session('user')['id'])->first(['email']);


                            if($request->new_email != $check->email){
                                $json = [
                                    'emailStatus' => 1,
                                    'msg' => 'ستصل رسالة الى بريدك الإلكتروني الجديد لتفعيله, وسيتم تغيير بريدك عند تفعيل البريد الجديد'
                                ];
                                user::where('id', session('user')['id'])->update(['emailConfirm' => 0]);

                                link::add($request['new_email'], 1);
                            }
                        user::where('id', session('user')['id'])->update($param);
                        session()->forget('user');
                        $user = \App\user::where('id',session('user')['id'])->first();
                        session(['user' => $user->toArray()]);
                        $json['status'] = 1;
                    } else {
                        $json['status'] = 0;
                        $json['msg'] = 'كلمة المرور الحالية خاطئة';
                    }
                } else {
                    $step = json_decode($user->finishProfileStep);
                    if (!isset($step->editProfile)) {
                        $step->editProfile = 1;
                        $param['finishProfileStep'] = json_encode($step);
                    }

//                     $json['fullname'] = $param['fname'] . ' ' . $param['lname'];
//                     $sesUser = session('user');
//                     $sesUser['isFinishProfile'] = 1;
//                     $sesUser['fname'] = $param['fname'];
//                     $sesUser['lname'] = $param['lname'];
                    $check = user::where('id', session('user')['id'])->first(['email']);
                    if($request->new_email != $check->email){
                        $json = [
                            'emailStatus' => 1,
                            'msg' => 'ستصل رسالة الى بريدك الإلكتروني الجديد لتفعيله, وسيتم تغيير بريدك عند تفعيل البريد الجديد'
                        ];
                        user::where('id', session('user')['id'])->update(['emailConfirm' => 0]);

                        link::add($request['new_email'], 1);
                    }
                    $param['isFinishProfile'] = 1;
                    user::where('id', session('user')['id'])->update($param);
                    $user = user::find(session('user')['id']);
                    session()->put('user', $user->toArray());
                    $json['status'] = 1;
                }
            }
        }

        return response()->json($json);
    }

    function deleteTest()
    {
        Storage::disk('local')->put('file.txt', 'Contents');
        echo 'done';


    }

    function deleteImage(Request $request)
    {
        global $setting;
        user::where('id', session('user')['id'])->update(['avatar' => '']);
        $user = session('user');
        if ($user['avatar'])
            ImageRepository::deleteImage($user['avatar']);
        $user['avatar'] = '';

        session()->put('user', $user);
        $user = \App\user::find(session('user')['id']);
        $male = \App\setting::where('set_id', 'MALE_AVATAR')->first(['set_data'])->set_data;
        $female = \App\setting::where('set_id', 'FEMALE_AVATAR')->first(['set_data'])->set_data;
        $imageType = $user?($user->gender == 1)?asset('images/users/'.$male):asset('images/users/'.$female):'';

        return response()->json(['status' => 1, 'filename' =>$imageType]);
    }

    function deleteFile($fileName)
    {
        $file = new FileRepository();
        $fileName = \App\file::where('id', $fileName)->first(['name'])->name;
        return json_encode($file->deleteI($fileName));
    }

    function handleAddPortfolio(Request $request)
    {
        $messages = [
            'Thumbnail.required' => 'يجب رفع صورة مصغرة للعمل',
        ];
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3|max:250',
            'description' => 'required|min:20',
            'skills' => 'required',
            'accomplishDate' => 'required',
            'Thumbnail' => 'required',
        ], $messages);
        if ($validator->fails()) {
            $json = [
                'status' => 0,
                'msg' => $validator->errors()->all()
            ];
        } else {
            $u = \App\user::where(['id'=>session('user')['id']])->first(['status'])->status;
            if($u == 2){
                $json['status'] = 0;
                $json['msg'] = 'تم حظر حسابك لايمكن اضافة المزيد من الاعمال';
                return response()->json($json);
            }


            if ($request['id'])
                $portfolio = portfolio::find($request['id']);
            else
                $portfolio = new portfolio();
            $portfolio->title = $request['title'];
            $portfolio->description = $request['description'];
            $portfolio->Thumbnail = $request['Thumbnail'];
            $portfolio->url = $request['url'];
            $portfolio->accomplishDate = $request['accomplishDate'];
            $portfolio->skills = json_encode($request['skills']);
            $portfolio->user_id = session('user')['id'];
            $portfolio->files = json_encode($request['files']);

          

            if ($portfolio->save()) {
                $json['status'] = 1;
                $json['date'] = $request['accomplishDate'];
                $user = user::find(session('user')['id']);
                $step = json_decode($user->finishProfileStep);
                if (!isset($step->addPortoflio)) {
                    $step->addPortoflio = 1;
                    $param['finishProfileStep'] = json_encode($step);
                    user::where('id', session('user')['id'])->update($param);
                }
            } else {
                $json['status'] = 0;
                $json['msg'] = 'حصل خطأ غير متوقع,الرجاء المحاولة مرة أخرى';
            }

            if (isset($request['files'])) {
                $filess = file::where('refer_id', $portfolio->id)->where('referal_type', 3)->whereNotIn('id', $request['files'])->get();
                file::where('refer_id', $portfolio->id)->where('referal_type', 3)->whereNotIn('id', $request['files'])->delete();
                file::whereIn('id', $request['files'])->update(['refer_id' => $portfolio->id, 'referal_type' => 3]);
            } else {
                $filess = file::where('refer_id', $portfolio->id)->where('referal_type', 3)->get();
                file::where('refer_id', $portfolio->id)->where('referal_type', 3)->delete();
            }
        }
        return response()->json($json);
    }

    function handleAddProject(Request $request)
    {
        $messages = [
            'Thumbnail.required' => 'يجب رفع صورة مصغرة للعمل',
            'files.required' => 'يجب رفع صورة واحدة على الأقل',
            'specialization_id.required' => 'حقل التخصص مطلوب',
            'specialization_id.integer' => 'حقل التخصص يجب ان يكون رقم',
        ];
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:20|max:250',
            'description' => 'required|min:20',
            'skills' => 'required',
            'budget_id' => 'required',
            'deliveryDuration' => 'required|integer',
            'specialization_id' => 'required|integer',
            'user_id' => 'exists:user,id',
        ], $messages);
        if ($validator->fails()) {
            $json = [
                'status' => 0,
                'msg' => $validator->errors()->all()
            ];
        } else {
            global $setting;
            if (!$setting['isBlock']) {
                if ($request['id'])
                    $project = project::find($request['id']);
                else
                    $project = new project();

                if ($request->freelancer_id) {
                    $project->isPrivate = 1;
                    $project->freelancer_id = $request->freelancer_id;
                }
                $project->title = preg_replace('/\s+/', ' ', $request['title']);
                $project->description = $request['description'];
                $project->budget_id = $request['budget_id'];
                $project->specialization_id = $request['specialization_id'];
                $project->status = 1;
                $project->deliveryDuration = $request['deliveryDuration'];
                if (isset($request->projectOwner_id)) {
                    $project->projectOwner_id = $request->projectOwner_id;
                    $project->isVIP = 1;
                    $project->VIPUser = session('user')['id'];
                } else
                    $project->projectOwner_id = session('user')['id'];

                if (isset($request['files']))
                    $project->files = json_encode($request['files']);
                $project->save();
                if ($request->freelancer_id) {
                    if($project->status == 2){
                        notifcation::addNew(10, $project->id, $request->freelancer_id, 'مشروع خاص', ' تم دعوتك لاضافة عرض على مشروع خاص.  ' . $project->title, session('user')['id']);
                    }else {
                        $not1 = new notifcation();
                        $not1->type = 10;
                        $not1->owner_id = session('user')['id'];
                        $not1->user_id = $request->freelancer_id;
                        $not1->type_id = $project->id;
                        $not1->title = 'مشروع خاص';
                        $not1->details = ' تم دعوتك لاضافة عرض على مشروع خاص.  ' . $project->title;
                        $not1->project_id = $project->id;
                        $not1->save();
                    }
                }
                //this new  added by me
                /////////////////////////////////////////////////
                $user = \App\user::find($request->freelancer_id);
                if($project->status == 2){
                if (!empty($user->device_token)) {
                    $m1 = ['en' => ' تم دعوتك لاضافة عرض على مشروع خاص.  ' . $project->title];
                    $url = url('/').'/project/'.$project->id.'-'.$project->title;
                    sendNotification($m1, $user->device_token, 'project',$url);
                }
                }
                //////////////////////////////////////////////////

                $step = json_decode(session('user')['finishProfileStep']);
                if (!isset($step->addProject)) {
                    $step->addProject = 1;
                    $param['finishProfileStep'] = json_encode($step);
                }
                $param['isFinishProfile'] = 1;
                user::where('id', session('user')['id'])->update($param);

                if (isset($request['files'])) {
                    $filess = file::where('refer_id', $project->id)->where('referal_type', 3)->whereNotIn('id', $request['files'])->get();
                    file::where('refer_id', $project->id)->where('referal_type', 3)->whereNotIn('id', $request['files'])->delete();
                    file::whereIn('id', $request['files'])->update(['refer_id' => $project->id, 'referal_type' => 3]);
                } else {
                    $filess = file::where('refer_id', $project->id)->where('referal_type', 3)->get();
                    file::where('refer_id', $project->id)->where('referal_type', 3)->delete();
                }
                if (sizeof($filess)) {
                    $ff = new FileRepository();
                    $ff->deleteMultiple($filess);
                }


                $skillRows = array();
                foreach ($request['skills'] as $value) {
                    $skill['skill_id'] = $value;
                    $skill['project_id'] = $project->id;
                    $skillRows[] = $skill;
                }
                projectskills::insert($skillRows);
                if ($project->save()) {
                    $json['status'] = 1;
                    $json['date'] = $request['accomplishDate'];
                } else {
                    $json['status'] = 0;
                    $json['msg'] = 'حصل خطأ غير متوقع,الرجاء المحاولة مرة أخرى';
                }
            } else {
                $json['status'] = 0;
                $json['msg'] = 'تم حظر حسابك من قبل الإدارة';
            }
        }
        return response()->json($json);
    }

    function like(Request $request)
    {
        if (like::checkAndAdd($request['user_id'], $request['refer_id'], $request['type'])) {
            $json['status'] = 1;
            $json['msg'] = 'تم اضافة اعجابك على هذا العمل';
        } else {
            $json['msg'] = 'تم الغاء اعجابك عن هذا العمل';
            $json['status'] = 0;
        }
        return response()->json($json);
    }

    function fovarite(Request $request)
    {
        if (favorite::checkAndAdd(session('user')['id'], $request['refer_id'], $request['type'])) {
            $json['status'] = 1;
            $json['text'] = 'الغاء التفضيل';
            $json['msg'] = 'تم اضافة هذا العمل الى مفضلتك ,للإطلاع على مفضلتك انقر على <a href="/myFavorite" >الرابط هنا</a>';
        } else {
            $json['msg'] = 'تم إزالة منجز المشاريع من مفضلتك الشخصية' . 'للإطلاع على مفضلتك انقر على  <a href="/myFavorite" >الرابط هنا</a>';
            $json['text'] = 'اضف للمفضلة';
            $json['status'] = 2;
        }
        $json['textType'] = 'favorite';
        if ($request->ajax())
            return response()->json($json);
        else {
            session()->flash('msg', $json['msg']);
            return redirect('/freelancer');
        }
    }

//    new favorite function for all

    function favorite(Request $request)
    {

        if ($request['type'] == 1)
            $type = 'العمل';
        else if ($request['type'] == 2)
            $type = 'المشروع';
        else {
            $type = 'منجز المشاريع';
            $json['Active'] = '#freelancerIcon';
        }
        $json['text'] = 'اضف للمفضلة';
        $json['textType'] = 'favorite';

        if (favorite::checkAndAdd(session('user')['id'], $request['refer_id'], $request['type'])) {
            $json['status'] = 1;
            $json['msg'] = 'تم اضافة  ' . $type . ' الى مفضلتك ,للإطلاع على مفضلتك انقر على <a href="/myFavorite" >الرابط هنا</a>';
            $json['text'] = 'إلغاء التفضيل';
        } else {

            $json['msg'] = 'تم ازالة ' . $type . ' من المفضلة الشخصية,للإطلاع على مفضلتك انقر على <a href="/myFavorite" >الرابط هنا</a>';
            $json['status'] = 0;
        }
        if ($request->ajax())
            return response()->json($json);
        else {
            session()->flash('msg', $json['msg']);
            if ($request['type'] == 1)
                return redirect('/portofolio/' . $request['refer_id']);
            else if ($request['type'] == 2)
                return redirect('/project/' . $request['refer_id']);
            else
                return redirect('/freelancers/' . $request['refer_id']);
        }
    }


    function favoriteNew(Request $request)
    {

        if ($request['type'] == 1)
            $type = 'العمل';
        else if ($request['type'] == 2)
            $type = 'المشروع';
        else {
            $type = 'منجز المشاريع';
            $json['Active'] = '#freelancerIcon';
        }
        $json['text'] = 'اضف للمفضلة';
        $json['textType'] = 'favorite';

        if (favorite::checkAndAdd(session('user')['id'], $request['refer_id'], $request['type'])) {
            $json['status'] = 1;
            $json['msg'] = 'تم اضافة  ' . $type;
            $json['text'] = 'إلغاء التفضيل';
        } else {

            $json['msg'] = 'تم ازالة ' . $type;
            $json['status'] = 0;
        }
        if ($request->ajax())
            return response()->json($json);
        else {
            session()->flash('msg', $json['msg']);
            if ($request['type'] == 1)
                return redirect('/portofolio/' . $request['refer_id']);
            else if ($request['type'] == 2)
                return redirect('/project/' . $request['refer_id']);
            else
                return redirect('/freelancers/' . $request['refer_id']);
        }
    }


    function report(Request $request)
    {
        if (report::checkAndAdd($request['report'], session('user')['id'], $request['refer_id'], $request['type'])) {

        }
        $json['status'] = 1;
        $json['msg'] = 'تم ارسال التبليغ .';
        if ($request->ajax())
            return response()->json($json);
        else {
            session()->flash('error', 'تم ارسال التبليغ');
            return redirect()->back();
        }
    }

    function addBids(Request $request)
    {
        global $setting;
        $messages = [
        ];

        if (session('user')['type'] == 2) {
            $json['status'] = 0;
            $json['msg'] = 'يجب ان يكون حسابك منجز مشاريع حتى تستطيع اضافة العروض ,' . 'لتعديل الملف الشخصي ' . '<a href="/editProfile">اضغط هنا</a>';
            return response($json);
        }
        $validator = Validator::make($request->all(), [
            'deliveryDuration' => 'required|integer',
            'cost' => 'required|integer',
            'letter' => 'required|min:50',
            'project_id' => 'required',
        ], $messages);
        if ($validator->fails()) {
            $json = [
                'status' => 0,
                'msg' => $validator->errors()->all()
            ];
        } else {
            if (!$setting['isBlock']) {
                $userId = session('user')['id'];
                $bid = bid::where('freelancer_id', $userId)->where('project_id', $request['project_id'])->first();
                $project = project::where(function ($q) use ($request) {
                    $q->where('isPrivate', 0)->orWhere('freelancer_id', session('user')['id']);
                })->find($request->project_id);

                if (!$project) {
                    $json = [
                        'status' => 0,
                        'msg' => 'لقد قدمت عرضك على هذا المشروع من قبل'
                    ];
                } else {
                    if ((!$request['id']) && $bid) {
                        $json = [
                            'status' => 0,
                            'msg' => 'لقد قدمت عرضك على هذا المشروع من قبل'
                        ];
                    } else {
                        if (!$project->isBlock) {
                            if ($request['id'] || bid::havebids($userId)) {
                                $param = $request->only('deliveryDuration', 'cost', 'letter', 'project_id');
                                $site_rate = $setting['site_rate'];
                                $param['dues'] = (1 - $site_rate) * $request['cost'];
                                $param['freelancer_id'] = session('user')['id'];
                                $bid = bid::where('id', $request['id'])->where('freelancer_id', session('user')['id'])->first();
                                $json['msg'] = 'تم تعديل العرض';

                                if (!$bid) {
                                    $bid = new bid();
                                    $json['msg'] = 'تم تقديم عرضك';
                                    notifcation::addNew(3, $project->id, $project->projectOwner_id, 'عرض جديد', 'تم اضافة عرض جديد على مشروع ' . $project->title, session('user')['id']);

                                    //this new  added by me
                                    /////////////////////////////////////////////////
                                    $user = \App\user::find($project->projectOwner_id);
                                    if (!empty($user->device_token)) {
                                        $m1 = ['en' =>  'تم اضافة عرض جديد على مشروع ' . $project->title];
                                        $url = url('/').'/project/'.$project->id.'-'.$project->title;
                                        sendNotification($m1, $user->device_token, 'project',$url);
                                    }
                                    //////////////////////////////////////////////////

                                } else {
                                    notifcation::addNew(6, $project->id, $project->projectOwner_id, 'تعديل عرض', ($bid->owner ? $bid->owner->fullname() : '') . ' قام بتعديل عرض على مشروع : ' . $project->title, session('user')['id']);

                                    //this new  added by me
                                    /////////////////////////////////////////////////
                                    $user = \App\user::find($project->projectOwner_id);
                                    if (!empty($user->device_token)) {
                                        $m1 = ['en' => ($bid->owner ? $bid->owner->fullname() : '') . ' قام بتعديل عرض على مشروع : ' . $project->title];
                                        $url = url('/').'/project/'.$project->id.'-'.$project->title;
                                        sendNotification($m1, $user->device_token, 'project',$url);
                                    }
                                    //////////////////////////////////////////////////
                                }
                                if($project->budget->min>$param['cost']){
                                    $json = [
                                        'status' => 0,
                                        'msg' => 'لايمكنك وضع سعر أقل من الحد الأدنى للميزانية المقترحة'
                                    ];
                                }else{
                                    $json['status'] = 1;
                                    $bid->deliveryDuration = $param['deliveryDuration'];
                                    $bid->cost = $param['cost'];
                                    $bid->letter = $param['letter'];
                                    $bid->project_id = $param['project_id'];
                                    $bid->dues = $param['dues'];
                                    $bid->freelancer_id = $param['freelancer_id'];
                                    $bid->save();


//                        profile step
                                    //$user = user::find(session('user')['id']);
                                    $step = json_decode(session('user')['finishProfileStep']);
                                    if (!isset($step->addbid)) {
                                        $step->addbid = 1;
                                        $param1['finishProfileStep'] = json_encode($step);
                                        user::where('id', session('user')['id'])->update($param1);
                                    }
                                    if (isset($request['files'])) {
                                        $filess = file::where('refer_id', $bid->id)->where('referal_type', 2)->whereNotIn('id', $request['files'])->get();
                                        file::where('refer_id', $bid->id)->where('referal_type', 2)->whereNotIn('id', $request['files'])->delete();
                                        file::whereIn('id', $request['files'])->update(['refer_id' => $bid->id, 'referal_type' => 2]);
                                    } else {
                                        $filess = file::where('refer_id', $bid->id)->where('referal_type', 2)->get();
                                        file::where('refer_id', $bid->id)->where('referal_type', 2)->delete();
                                    }
                                    if (sizeof($filess)) {
                                        $ff = new FileRepository();
                                        $ff->deleteMultiple($filess);
                                    }
                                    $data['setting'] = $setting;
                                    $data['project'] = $project;

                                    $data['userBid'] = bid::where('freelancer_id', $userId)->where('project_id', $request['project_id'])
                                        ->with('user')->with('user.freelancerEvaluate')->first();
                                    $json['view'] = view('project.userBid', $data)->render();

                                }


                            } else {
                                $json['status'] = 0;
                                $json['msg'] = 'ليس لديك اي عروض متاحة';
                            }
                        } else {
                            $json['status'] = 0;
                            $json['msg'] = 'هذا المشروع محظور ';
                        }
                    }
                }
            } else {
                $json['status'] = 0;
                $json['msg'] = 'تم حظر حسابك من قبل الإدارة';
            }
        }
        return response()->json($json);
    }

    function addDescussion(Request $request)
    {
        global $setting;
        $messages = [
        ];
        $validator = Validator::make($request->all(), [
            'content' => 'required|min:25',
            'project_id' => 'required',
        ], $messages);
        if ($validator->fails()) {
            $json = [
                'status' => 0,
                'msg' => $validator->errors()->all()
            ];
        } else {
            $project = project::find($request->project_id);
            if (sizeof($project->freelancer) &&
                (($project->freelancer[0]->freelancer_id == session('user')['id']) || ($project->projectOwner_id == session('user')['id']) || ($project->VIPUser) == session('user')['id']
                )
            ) {


                if ($project->status == 3) {
                    if (!session('user')['isVIP'])
                        $userId = session('user')['id'];
                    else
                        $userId = $project->projectOwner_id;
                    $param = $request->only('content', 'project_id');
                    $param['user_id'] = $userId;
                    $json['status'] = 1;
                    $descussion = new projectDescussion();
                    $descussion->user_id = $userId;
                    $descussion->content = $request['content'];
                    $descussion->project_id = $request->project_id;
                    $descussion->save();
                    if (session('user')['id'] == $project->freelancer[0]->freelancer_id)
                        $userNoti = $project->projectOwner_id;
                    else
                        $userNoti = $project->freelancer[0]->freelancer_id;

                    notifcation::addNew(5, $project->id, $userNoti, ' استفسار جديد', 'هناك رسالة جديدة على مشروع : ' . $project->title, $userId, $project->VIPUser);

                    //this new  added by me
                    /////////////////////////////////////////////////
                    $user = \App\user::find($userNoti);
                    if (!empty($user->device_token)) {
                        $m1 = ['en' =>'هناك رسالة جديدة على مشروع : ' . $project->title];
                        $url = url('/').'/project/'.$project->id.'-'.$project->title;
                        sendNotification($m1, $user->device_token, 'project',$url);
                    }
                    /////////////////////////////////////////////////

                    if (isset($request['files'])) {
                        file::whereIn('id', $request['files'])->update(['refer_id' => $descussion->id, 'referal_type' => 5]);
                    }
                    $data['descussions'] = projectDescussion::where('id', $descussion->id)->with('file')->with('sender')->get();
                    $json['view'] = view('project.singleDescussen', $data)->render();
                    $json['msg'] = 'تم اضافة ردك';
                } else {
                    $json['status'] = 0;
                    $json['msg'] = 'تم انهاء المشروع';
                    session()->flash('msg', 'تم انهاء المشروع');
                    $json['url'] = '/project/' . $request->project_id;
                }
            } else {
                $json['status'] = 0;
                $json['msg'] = 'ليس لديك صلاحية لاضافة نقاش على هذا المشروع';
                $json['url'] = '/project/' . $request->project_id;
                session()->flash('error', $json['msg']);
            }
        }
        return response()->json($json);
    }

    function evaluate(Request $request)
    {
        global $setting;
        $messages = [
        ];
        $validator = Validator::make($request->all(), [
            'CommunicationAndMonitoring' => 'required|integer|between:1,5',
            'project_id' => 'required|integer|exists:projects,id',
            'note' => 'required|max:1000',
            'experience' => 'required|integer|between:1,5',
            'ProfessionalAtWork' => 'required|integer|between:1,5',
            'quality' => 'required|integer|between:1,5',
            'workAgain' => 'required|integer|between:1,5',
        ], $messages);
        if ($validator->fails()) {
            $json = [
                'status' => 0,
                'msg' => implode(',', $validator->errors()->all())
            ];
        } else {
            $project = project::where(function ($q) {
                $q->where('projectOwner_id', session('user')['id'])->orWhere('VIPUser', session('user')['id']);
            })->find($request->project_id);
            if ($project && $project->freelancer[0]) {
                $evaluate = evaluate::where('project_id', $request->project_id)->where('evaluating_owner', $project->freelancer[0]->freelancer_id)->first();
                if (!$evaluate) {
                    $evaluate = new evaluate();
                    $evaluate->CommunicationAndMonitoring = $request->CommunicationAndMonitoring;
                    $evaluate->project_id = $request->project_id;
                    $evaluate->note = $request->note;
                    $evaluate->experience = $request->experience;
                    $evaluate->ProfessionalAtWork = $request->ProfessionalAtWork;
                    $evaluate->quality = $request->quality;
                    $evaluate->workAgain = $request->workAgain;
                    $evaluate->evaluating_owner = $project->freelancer[0]->freelancer_id;
                    $evaluate->evaluated_id = session('user')['id'];
                    $evaluate->save();

                    notifcation::addNew(7, $project->freelancer[0]->freelancer_id, $project->freelancer[0]->freelancer_id, 'تقيم جديد', 'تم تقييمك على مشروع ' . $project->title, session('user')['id']);
//                    notifcation::addNew(9, $project->freelancer[0]->freelancer_id, $project->freelancer[0]->freelancer_id, 'تقيم جديد', 'تم تقييمك على مشروع ' . $project->title, session('user')['id']);

                    //this new  added by me
                    /////////////////////////////////////////////////
                    $user = \App\user::find($project->freelancer[0]->freelancer_id);
                    if (!empty($user->device_token)) {
                        $m1 = ['en' => 'تم تقييمك على مشروع ' . $project->title];
                        $url = url('/').'/project/'.$project->id.'-'.$project->title;
                        sendNotification($m1, $user->device_token, 'project',$url);
                    }
                    /////////////////////////////////////////////////

                    $evaluates = evaluate::where('evaluating_owner', $project->freelancer[0]->freelancer_id)->get();
                    $avg = ($evaluates->avg('ProfessionalAtWork') +
                            $evaluates->avg('CommunicationAndMonitoring') +
                            $evaluates->avg('quality') +
                            $evaluates->avg('experience') +
                            $evaluates->avg('workAgain')) / 5;
                    user::where('id', $project->freelancer[0]->freelancer_id)->update(['stars' => $avg]);
                    $json['status'] = 1;
                    $json['msg'] = 'تهانينا !! لقد انهيت المشروع ';
//                    $json['url'] = '/evaluate/' . $request->project_id;
                    $json['url'] = '/projects';
                } else {
                    $json['status'] = 0;
                    $json['msg'] = 'لا يمكنك تقيم المنجز مرتين على نفس المشروع';
                }
            } else {
                $json['status'] = 0;
                $json['msg'] = 'لا يمكنك تقيم هذا المنجز';
            }
        }
        return response()->json($json);
    }


    function notifcationSettingPost(Request $request)
    {
        $this->validate($request, [
            'notiPerms' => 'required',
        ]);
        $allPerm = $request->notiPerms;
        $inPerm = \App\notifcationPerm::whereIn('type', $request->notiPerms)->where('user_id', session('user')['id'])->get()->pluck('type', null)->toArray();

        $notInPerm = [];
        foreach ($allPerm as $key => $value) {
            if (array_search($value, $inPerm) === false) {
                $notInPerm[] = $value;
            }
        }


        \App\notifcationPerm::whereNotIn('type', $allPerm)->where('user_id', session('user')['id'])->delete();

        $insert = [];
        foreach ($notInPerm as $key => $value) {
            $raw['type'] = $value;
            $raw['user_id'] = session('user')['id'];
            $insert[] = $raw;
        }
        \App\notifcationPerm::insert($insert);
        return redirect()->back();
    }

    function orderFinishProject($id)
    {
        $project = project::where('status', 3)->find($id);
        if ($project && sizeof($project->freelancer) && $project->freelancer[0]->freelancer_id == session('user')['id']) {
            if (!$project->idBlock) {
                if (!$project->freelancer[0]->freealancerFinish) {
                    projectFreelancer::where('id', $project->freelancer[0]->id)->update(['freealancerFinish' => 1]);
                    $notiMsg = getNotifcationMessage('orderFinishRequest', $project->freelancer[0]->user->fullname(), $project->title);
                    notifcation::addNew(7, $id, $project->projectOwner_id, trans('lang.orderFinishRequest'), $notiMsg, session('user')['id']);

                    //this new  added by me
                    /////////////////////////////////////////////////
                    $user = \App\user::find($project->projectOwner_id);
                    if (!empty($user->device_token)) {
                        $m1 = ['en' =>$notiMsg];
                        $url = url('/').'/project/'.$project->id.'-'.$project->title;
                        sendNotification($m1, $user->device_token, 'project',$url);
                    }
                    ////////////////////////////////////////////////////
                    $json['status'] = 1;
                    $json['msg'] = 'تم تقديم طلب الإنهاء بإنتظار موافقة صاحب المشروع';
                } else {
                    $json['status'] = 0;
                    $json['msg'] = 'لقد قدمت طلب انهاء المشروع من قبل الرجاء انتظار رد صاحب المشروع';
                }
            } else {
                $json['status'] = 0;
                $json['msg'] = 'هذا المشروع محظور';
            }
        } else {
            $json['status'] = 0;
            $json['msg'] = 'ليس لديك صلاحية لهذا المشروع';
        }
        if (request()->ajax())
            return response()->json($json);
        else
            return redirect('project/' . $id);
    }

    function finishProject($id)
    {
        $project = project::find($id);
        if ($project && ($project->projectOwner_id == session('user')['id'] || $project->VIPUser == session('user')['id'])) {
            if ($project->status == 3) {
                if (!$project->idBlock) {

// || $project->isBack == 1
                    if ($project->freelancer[0]->freealancerFinish ) {
                        $user_id = $project->projectOwner_id;
                        $bid = bid::where('project_id', $id)->where('freelancer_id', $project->freelancer[0]->freelancer_id)->first();

                        project::where('id', $id)->update(['status' => 6]);
                        bid::where('id', $bid->id)->update(['status' => 3]);
                        projectFreelancer::where('id', $project->freelancer[0]->id)->update(['status' => 3]);

                        $transactionType = 1;
                        transaction::transfer($project->projectOwner_id, $project->freelancer[0]->freelancer_id, $bid->cost, $bid->dues,3,  $transactionType);
                        user::where('id', $project->projectOwner_id)->update(['balance' => DB::raw('balance-' . $bid->cost), 'suspended_balance' => DB::raw('suspended_balance-' . $bid->cost)]);
                        user::where('id', $project->freelancer[0]->freelancer_id)->update(['balance' => DB::raw('balance+' . $bid->dues), 'suspended_balance' => DB::raw('suspended_balance+' . $bid->dues)]);
                        $notiMsg = getNotifcationMessage('finishProject', $project->owner->fullname(), $project->title);
                        notifcation::addNew(7, $id, $project->freelancer[0]->freelancer_id, trans('lang.finishProject'), $notiMsg, $user_id);

                        //this new  added by me
                       /////////////////////////////////////////////////
                        $user = \App\user::find($project->freelancer[0]->freelancer_id);
                        if (!empty($user->device_token)) {
                            $m1 = ['en' =>$notiMsg];
                            $url = url('/').'/project/'.$project->id.'-'.$project->title;
                            sendNotification($m1, $user->device_token, 'project',$url);
                        }
                        ///////////////////////////////////////////

                        $json['url'] = "/evaluate/" . $id;
                        $json['status'] = 1;
                        $json['msg'] = 'تهانينا لقد أنهيت المشروع';
                    } else {
                        $json['status'] = 0;
                        $json['msg'] = 'يجب ان يطلب المنجز انهاء المشروع اولا';
                    }
                } else {
                    $json['status'] = 0;
                    $json['msg'] = 'هذا المشروع محظور';
                }
            } else {
                $json['status'] = 0;
                $json['msg'] = 'لا يمكنك انهاء هذا المشروع';
            }
        } else {
            $json['status'] = 0;
            $json['msg'] = 'ليس لديك صلاحية لهذا المشروع';
        }
        if (request()->ajax())
            return response()->json($json);
        else
            return redirect('/project/' . $id);
    }

    function withdrawRequest(Request $request)
    {
        global $setting;
        $messages = [
        ];
        $validator = Validator::make($request->all(), [
            'email' => 'required|',
            'amount' => 'required|integer|min:1',
        ], $messages);
        if ($validator->fails()) {
            $json = [
                'status' => 0,
                'msg' => implode(',', $validator->errors()->all())
            ];
        } else {
            $user = user::find(session('user')['id']);
            if (($user->balance - $user->suspended_balance) >= $request->amount) {
                $withdraw = withdrawRequest::where('user_id', session('user')['id'])->where('status', 1)->first();
                if ($withdraw) {

                    $json['status'] = 0;
                    $json['withdrawrequest'] = $withdraw;
                    $json['msg'] = 'لديك طلب سحب الرجاء انتظار انتهاء الطلب القديم';
                } else {

                    withdrawRequest::add($request);
                    $json['status'] = 1;
                    $json['msg'] = 'لقد استقبلنا طلبك وسيتم الرد تنفيذ الطلب خلال 24 ساعة';
                }
            } else {
                $json['status'] = 0;
                $json['msg'] = 'المبلغ المدخل أكبر من المبلغ القابل للسحب ';
            }
        }

        return response()->json($json);
    }

    function sendMessage(Request $request)
    {
        global $setting;
        $messages = [
        ];
        $validator = Validator::make($request->all(), [
            'conversation_id' => 'required|integer',
            'content' => 'required',
        ], $messages);
        if ($validator->fails()) {
            $json = [
                'status' => 0,
                'msg' => $validator->errors()->all()
            ];
        } else {
            $user_id = session('user')['id'];
            $con = conversation::where('id', $request['conversation_id'])->where(function ($q) use ($user_id) {
                $q->where('sender_id', $user_id)->orWhere('reciever_id', $user_id)->orWhere('VIPUser', $user_id);
            })->where('status', 1)->first();
            if ($con) {

                if (!$con->isBlock) {
                    $last = message::where('conversation_id', $con->id)->orderBy('id', 'desc')->first();
                    if ($last && $last->reciever_id == $user_id) {
                        $user = user::find($user_id);
                        $date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $last->created_at);
                        $now = \Carbon\Carbon::now();
                        $diffInSecond = $now->diffInSeconds($date);
                        if ($user->responseSpeed) {
                            $responseSpeed = (($user->responseSpeed * $user->responseSpeedNo) + $diffInSecond) / $user->responseSpeedNo + 1;
                            user::where('id', $user_id)->update(['responseSpeedNo' => $user->responseSpeedNo + 1, 'responseSpeed' => $responseSpeed]);
                        } else {
                            user::where('id', $user_id)->update(['responseSpeedNo' => 1, 'responseSpeed' => $diffInSecond]);
                        }
                    }
                    $sendUser = null;
                    $projectTitle = \App\conversation::find($request['conversation_id'])->project->title;
                    $message = new message();
                    $message->conversation_id = $request['conversation_id'];
                    $message->content = $request['content'];
                    if (session('user')['isVIP']) {
                        $message->sender_id = $con->sender_id;
                        $message->reciever_id = $con->reciever_id;
                        $sendUser = \App\user::find($con->reciever_id);
                    } else {
                        $message->sender_id = $user_id;
                        $message->reciever_id = ($con->sender_id == $user_id) ? $con->reciever_id : $con->sender_id;
                        $sendUser = \App\user::find( ($con->sender_id == $user_id) ? $con->reciever_id : $con->sender_id);
                    }
                    if ($con->VIPUser) {
                        $message->VIPUser = $con->VIPUser;
                        if (session('user')['id'] == $con->reciever_id)
                            $message->VIPSeen = 0;
                    }


                    if (!empty($sendUser->device_token)) {
                        $m1 = ['en' => 'لديك رسالة جديدة على مشروع :'.$projectTitle.' '.str_limit($request['content'],30)];
                        $url = url('/').'/conversation/'.$request['conversation_id'];
                        sendNotification($m1, $sendUser->device_token, 'message',$url);
                    }
                    $message->save();
                    if ($request['files']) {
                        file::whereIn('id', $request['files'])->update(['refer_id' => $message->id, 'referal_type' => 4]);
                    }
                    $data['files'] = file::where('refer_id', $message->id)->where('referal_type', 4)->get();
                    $json['status'] = 1;
                    $data['message'] = $message;
                    $json['view'] = view('message.message', $data)->render();
                } else {
                    $json['status'] = 0;
                    $json['msg'] = 'تم حظر هذه المحادثة الرجاء التواصل مع الإدارة';
                }
            } else {
                $json['status'] = 0;
                $json['msg'] = 'فشل ارسال الرسالة';
            }
        }
        return response()->json($json);
    }

    function addFreelancer(Request $request)
    {

        $messages = [
        ];
        $validator = Validator::make($request->all(), [
            'bid_id' => 'required|integer',
        ], $messages);
        if ($validator->fails()) {
            $json = [
                'status' => 0,
                'msg' => $validator->errors()->all()
            ];
        } else {
            $bid = bid::with('project')->where('id', $request['bid_id'])->first();
            if ($bid) {
                if (session('user')['id'] == $bid->project->projectOwner_id || session('user')['id'] == $bid->project->VIPUser) {
                    $isClose = $bid->project->isClose();
                    if (!$isClose) {
                        if ($bid->project->status == 3 && sizeof($bid->project->freelancer)) {
                            if ($bid->project->freelancer[0]->freelancer_id === $bid->freelancer_id) {

                                $json['status'] = 0;
                                $json['msg'] = $bid->project->freelancer[0]->user->fullname() . ' بدأ فعليا العمل على هذا المشروع ';
                            } else {

                                $json['status'] = 0;
                                $json['msg'] = 'لقد سلمت هذا المشروع ل ' . $bid->project->freelancer[0]->user->fullname() .
                                    ',لعرض المشروع ' . '<a href="/project/' . $bid->project_id . '">اضغط هنا</a>';
                            }
                        } else {
                            $balance = user::myBalance($bid->project->projectOwner_id);
                            if (!$bid->project->isBlock) {
                                if (!$bid->isBlock) {
                                    global $setting;
                                    if (!$setting['isBlock']) {
                                        if ($balance >= $bid->cost) {
// //                                transaction
//                                 $trans = new transaction();
//                                 $trans->reciever_id = $bid->freelancer_id;
//                                 $trans->sender_id = $bid->project->projectOwner_id;
//                                 $trans->amount = $bid->cost;
//                                 $trans->status = 1;
//                                 $trans->save();

                                            user::where('id', $bid->project->projectOwner_id)->update(['suspended_balance' => DB::raw('suspended_balance +' . $bid->cost)]);


                                            $json['status'] = 1;
                                            $json['msg'] = 'تم اختيار ' . $bid->user->fullname() . ' للعمل على مشروعك :' . $bid->project->title;
                                            $con = conversation::where('project_id', $bid->project_id)->where(function ($q) use ($bid) {
                                                $q->where('sender_id', $bid->freelancer_id)->orWhere('reciever_id', $bid->freelancer_id);
                                            })->where('status', 1)->first();
                                            if (!$con) {
                                                $con = new conversation();
                                                $con->project_id = $bid->project_id;
                                                $con->sender_id = $bid->project->projectOwner_id;
                                                $con->reciever_id = $bid->freelancer_id;
                                                $con->status = 1;
                                                $con->save();
                                            }
                                            project::where('id', $bid->project_id)->update(['status' => 3]);
                                            bid::where('project_id', $bid->project_id)->update(['status' => 6]);
                                            bid::where('id', $bid->id)->update(['status' => 2]);
                                            $pf = new projectFreelancer();
                                            $pf->project_id = $bid->project_id;
                                            $pf->freelancer_id = $bid->freelancer_id;
                                            $pf->status = 1;
                                            $pf->deliveryDuration = $bid->deliveryDuration;
                                            $pf->cost = $bid->cost;
                                            $pf->save();

                                            notifcation::addNew(4, $bid->project_id, $bid->freelancer_id, 'تثبيت المشروع', 'تهانينا .. تم اختيارك للعمل على مشروع ' . $bid->project->title, session('user')['id']);

                                            //this new  added by me
                                            /////////////////////////////////////////////////
                                            $user = \App\user::find($bid->freelancer_id);
                                            if (!empty($user->device_token)) {
                                                $m1 = ['en' => 'تهانينا .. تم اختيارك للعمل على مشروع ' . $bid->project->title];
                                                $url = url('/').'/project/'.$bid->project->id.'-'.$bid->project->title;
                                                sendNotification($m1, $user->device_token, 'project',$url);
                                            }
                                            ///////////////////////////////////////////
                                            $json['url'] = '/project/' . $bid->project_id;
                                        } else {

                                            $json['status'] = 0;
                                            if (!session('user')['isVIP']) {
                                                $json['url'] = '/balance';
                                                $json['msg'] = ' لا يوجد لديك رصيد كافي';
                                            } else {
                                                $json['msg'] = 'لا يوجد رصيد كافي في حساب صاحب المشروع';
                                            }
                                            session()->flash('error', 'لا يوجد لديك رصيد كافي لتنفيذ المشروع ,اشحن رصيدك');
                                        }
                                    } else {
                                        $json['status'] = 0;
                                        $json['msg'] = 'تم حظر هذا المستخدم من قبل الإدارة';
                                    }
                                } else {
                                    $json['status'] = 0;
                                    $json['msg'] = 'هذا العرض محظور ا لرجاء اختيار عرض آخر او تواصل مع الإدارة';
                                }
                            } else {
                                $json['status'] = 0;
                                $json['msg'] = 'هذا المشروع محظور الرجاء التواصل مع الإدارة';
                            }
                        }
                    } else {
                        $json['status'] = 0;
                        $json['msg'] = $isClose;
                    }
                } else {
                    $json['status'] = 0;
                    $json['msg'] = 'حصل خطأ';
                }
            } else {
                $json['status'] = 0;
                $json['msg'] = 'حصل خطأ';
            }
        }
        return response()->json($json);
    }

}
