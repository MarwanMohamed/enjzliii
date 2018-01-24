<?php

namespace App\Http\Controllers\admin;

use App\bid;
use App\country;
use App\link;
use App\notifcation;
use App\portfolio;
use App\setting;
use App\admin;
use App\skill;
use Validator;
use App\Services\Encrypt;
use App\user;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\project;

class users extends Controller
{
    //
    function index(Request $request)
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
        $query = user::orderBy($orderBy, $orderByType)
            ->where(function ($q) use ($words, $columnSearch) {
                foreach ($words as $word) {
                    foreach ($columnSearch as $column)
                        $q->orWhere($column, 'like', '%' . $word . '%');
                }
            });

        $query->where('isdelete', 0)->where('isVIP',0);
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


        return view('admin/users/index', $data);
    }

    function statistic()
    {
        $lastDay = \Carbon\Carbon::today();
        $day = user::where('created_at', '>', $lastDay)->count();
        $week = user::where('created_at', '>', $lastDay->subWeeks(1))->count();
        $month = user::where('created_at', '>', $lastDay->subMonths(1))->count();
        $now = \Carbon\Carbon::now();
        $online = user::where('lastLogin', '>', $now->subMinutes(15))->select('lastLogin')->count();

        $all = user::count();
        $grouped = user::select(DB::raw('DATE(created_at) as date, DAY(created_at) as day'), DB::raw('count(*) as count'))
            ->groupBy('date')
            ->where('created_at', '>', $lastDay->subMonths(1))
            ->get()->pluck('count', 'day')->toArray();
        $last5 = user::limit(5)->latest()->get();
        return view('admin/users/statistic', compact('day', 'month', 'week', 'all', 'online', 'grouped', 'last5'));

    }


    function images()
    {

        $data['male'] = \App\setting::where('set_id', 'MALE_AVATAR')->first(['set_data'])->set_data;
        $data['female'] = \App\setting::where('set_id', 'FEMALE_AVATAR')->first(['set_data'])->set_data;
        return view('admin.users.images', $data);
    }

    function updateImages(Request $request)
    {

        if ($male = $request->file('male_image')) {
            $imageName = str_slug($male->getClientOriginalName()) . microtime() . '.' . $male->getClientOriginalExtension();
            $male->move('images/users', $imageName);
            \App\setting::where('set_id', 'MALE_AVATAR')->update(['set_data' => $imageName]);
        }
        if ($female = $request->file('female_image')) {
            $imageName = str_slug($female->getClientOriginalName()) . microtime() . '.' . $female->getClientOriginalExtension();
            $female->move('images/users', $imageName);
            \App\setting::where('set_id', 'FEMALE_AVATAR')->update(['set_data' => $imageName]);
        }

        return back()->with('msg', 'تمت عملية التعديل بنجاح');
    }

    function singleUser($id = 0)
    {
        $data['user'] = user::profile($id);
        if (sizeof($data['user'])) {
            $data['statistics'] = $statistics = user::Statistics($id);
            $user = \App\user::find($id);

            $data['evaluates'] = user::getEvaluate($id);

            $avatar = $user->avatar;
            if ($avatar && !str_contains($avatar, 'image_')) {
                $avatar = $avatar;
            }

            $male = \App\setting::where('set_id', 'MALE_AVATAR')->first(['set_data'])->set_data;
            $female = \App\setting::where('set_id', 'FEMALE_AVATAR')->first(['set_data'])->set_data;
            $imageType = $user ? ($user->gender == 1) ? asset('images/users/' . $male) : asset('images/users/' . $female) : '';

            $data['awaitingConfirmationBids'] = bid::where(['freelancer_id' => $id, 'status' => 1])->count();
            $data['underway'] = bid::where(['freelancer_id' => $id, 'status' => 2])->count();
            $data['complete'] = bid::where(['freelancer_id' => $id, 'status' => 3])->count();
            $data['canceled'] = bid::where(['freelancer_id' => $id, 'status' => 4])->count();
            $data['projects_complete_count'] = project::where(['projectOwner_id' => $id,'status'=>6])->count();
            $data['projects_count'] = project::where(['projectOwner_id' => $id])->where('status','<>',7)->count();
            $data['all'] = bid::where(['freelancer_id' => $id])->count();
            $data['bids_count'] = bid::where(['freelancer_id' => $id])->count();
            $data['closed']   = bid::where(['freelancer_id' => $id, 'status' => 5])->count();
            $data['away'] = bid::where(['freelancer_id' => $id, 'status' => 6])->count();
            $data['blocked'] = bid::where(['freelancer_id' => $id, 'status' => 7])->count();

            $data['imageType'] = ($avatar) ? '/image_r/200/' . $avatar : $imageType;
            $data['portfolios'] = portfolio::where('user_id', $id)
                ->with('likes')
                ->with('views')
                ->limit(6)->get();
            $data['bids'] = bid::getAll($id);
            $data['skills'] = skill::getUserSkills($id);
            return view('front.singleUser', $data);
        } else {
            session()->flash('errors', 'خطأ في الرابط');
            return redirect('msg');
        }
    }

    function delete($id)
    {
        user::where('id', $id)->update(['isdelete' => 1, 'deleted_at' => date('y-m-d h:i:s')]);
        session()->flash('msg', 'تم حذف المستخدم نهائيا');
        return redirect('admin/users');
    }
    function updateVip($id)
    {
        $vip = user::where('id', $id)->first(['isVIP'])->isVIP;
        user::where('id', $id)->update(['isVIP' => $vip==1?0:1, 'updated_at' => date('y-m-d h:i:s')]);


        $vip==0?session()->flash('msg', 'تم ترقية حساب المستخدم بنجاح'):session()->flash('msg', 'تم  ارجاع حساب المستخدم الى عادي بنجاح');
        return $vip==0?redirect('admin/users'):redirect('admin/super/show');
    }

    function block(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'blockReason' => 'required|min:20|max:500',
        ]);

        $blockReason = $request->blockReason;
        if ($validator->fails()) {
            session()->flash('errors', $validator->errors());
        } else {
            user::where('id', $request->id)->update(['status' => 2, 'blockReason' => $request->blockReason]);
            notifcation::addNew('', 0, $request->id, 'رسالة ادارية'," تم حظر حسابك  بسبب  ". $blockReason);
            session()->flash('msg', 'تم حظر المستخدم');
        }
        return redirect('admin/users');
    }

    function notifcation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'text' => 'required|min:20|max:500',
        ]);

        if ($validator->fails()) {
            session()->flash('errors', $validator->errors());
        } else {
            notifcation::addNew(1, 0, $request->id, 'رسالة ادارية', $request->text, 0);
            session()->flash('msg', 'تم ارسال رسالة ادارية');
        }
        return redirect('admin/users');
    }

    function activate($id)
    {
        user::where('id', $id)->update(['status' => 0]);
        notifcation::addNew('', 0, $id, 'رسالة ادارية', 'تم رفع الحظر عن حسابك ، يمكنك متابعه استخدام حسابك الان');
        session()->flash('msg', 'تم تفعيل المستخدم');
        return redirect(url()->previous());
    }
    function activateAccount($id)
    {
        $check =  user::where('id', $id)->first();
        if($check->emailConfirm == 0){
            user::where('id', $id)->update(['emailConfirm' => 1]);
            notifcation::addNew('', 0, $id, 'رسالة ادارية', 'تم تفعيل حسابك، يمكنك متابعه استخدام حسابك الان');
            session()->flash('msg', 'تم تفعيل حساب المستخدم');
        }else{
            user::where('id', $id)->update(['emailConfirm' => 0]);
            notifcation::addNew('', 0, $id, 'رسالة ادارية', 'تم ايقاف حسابك ويتم تسجيل الخروج تلقائياً');
            session()->flash('msg', 'تم إيقاف حساب المستخدم');
        }

        return redirect(url()->previous());
    }

    function single($id)
    {
        $user = user::with('bids')
            ->with('bids.project')
            ->with('myProjects')
            ->with('portfolios')
            ->with('freelancerEvaluates')
            ->with('freelancerEvaluates.evalutedUser')
            ->with('freelancerEvaluates.project')
            ->with('myProjects.specialization')
            ->with('myProjects.budget')
            ->find($id);
        if ($user) {
            $data['user'] = $user;
            return view('admin.users.single', $data);
        } else {
            $this->error('هذا المستخدم غير موجود');
        }
    }

    function add(Request $request)
    {
        $data['countries'] = country::get();
        return view('admin.users.add', $data);
    }

    function addPost(Request $request)
    {
        
        $this->validate($request, [
            'email' => 'email|max:100|required|unique:user,email',
            'fname' => 'required|min:3|max:50',
            'lname' => 'required|min:3|max:50',
            'country_id' => 'required|exists:country,id',
        ]);

        $param = $request->only('email', 'fname', 'lname', 'country_id');
        $param['emailConfirm'] = 1;
        $password = str_random(12);
         
        $param['finishProfileStep'] = json_encode(["emailConfirm" => 1]);
        
        
        $u = user::create($param);
        $encript = new Encrypt();
        $salt = $encript->genRndSalt();
        $encrypted_password = $encript->encryptUserPwd($password, $salt);
        $u->salt = $salt;
        $u->password = $encrypted_password;
        $u->save();
        
        
        
        link::sendRandomPassword($request['email'], $password);
        session()->flash('msg', 'تم اضافة مستخدم جديد وارسال رسالة تفعيل الى بريده الإلكتروني');
        return redirect('admin/users');
    }

    function setting(Request $request)
    {
        if (isset($request['users_isClose'])) {
            setting::add('users_isClose', $request->users_isClose);
            if (($request['users_isClose']))
                session()->flash('msg', 'تم اغلاق التسجيل في الموقع');
            else
                session()->flash('msg', 'تم اتاحة التسجيل في الموقع');
            return redirect('admin/users/setting');
        }

        return view('admin.users.setting');
    }


}
