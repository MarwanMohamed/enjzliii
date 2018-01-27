<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \App\admin;
use \App\setting;
use App\Services\Auth;
use \App\Services\Encrypt;
use \App\group_permission;
use \Illuminate\Support\Facades\DB;

class control extends Controller
{

    //

    function viewAdmin(Request $request)
    {
        $q = (isset($request['q'])) ? $request['q'] : '';
        $data['admins'] = admin::where('fullname', 'like', '%' . $q . '%')
            ->orwhere('email', 'like', '%' . $q . '%')
            ->with('group')
            ->paginate(20);
        $data['q'] = $q;

        return view('admin/control/admin', $data);
    }

    function newAdmin(Request $request)
    {
        $data['groups'] = group_permission::all();
        return view('admin.control.newAdmin', $data);
    }

    function newAdminPost(Request $request)
    {

        $this->validate($request, [
            'email' => 'required|unique:admin,email',
            'fullname' => 'required|min:5',
            'permission_group' => 'required|exists:permissiongroup,id',
        ]);
        $auth = new Auth();
        $encript = new Encrypt();
        $salt = $auth->generateRandomString(6);
        $password = $auth->generateRandomString(6, 'int');
        $newPassword = $encript->encryptUserPwd($password, $salt);

        $admin = new admin();
        $admin->email = $request['email'];
        $admin->fullname = $request['fullname'];
        $admin->password = $newPassword;
        $admin->salt = $salt;
        $admin->active = 1;
        $admin->permission_group = $request['permission_group'];
        $admin->save();
        $setting = Setting::siteSettings(['siteName', 'siteTitle', 'copyRights']);
        \Illuminate\Support\Facades\Mail
            ::to($request['email'])->send
            (new \App\Mail\SendMessage('كلمة مرور حسابك على لوحة التحكم هي  <h4>' . $password . '</h4>', $setting['siteName'], $setting['siteTitle'], $setting['copyRights']));
        session()->flash('msg', 'تم اضافة المدير ,وارسال كلمة المرور الى بريده الإلكتروني');


        return redirect(url()->previous());
    }

    function editAdmin($id)
    {
        $data['groups'] = group_permission::all();
        $data['admin'] = $admin = admin::find($id);
        if ($admin->email == 'admin@admin.com' || $id == session('admin')->id) {
            session()->flash('msg', 'لا يمكنك التعديل على هذا الحساب');
            return redirect(url()->previous());
        }
        return view('admin.control.editAdmin', $data);
    }

    function editAdminPost(Request $request)
    {
        $this->validate($request, [
            'fullname' => 'required|min:5',
            'permission_group' => 'required|exists:permissiongroup,id',
        ]);

        $admin = Admin::find($request['id']);
        $admin->fullname = $request['fullname'];
        $admin->permission_group = $request['permission_group'];
        $admin->save();

        session()->flash('msg', 'تم تعديل بيانات المدير');


        return redirect('admin/control/viewAdmin');
    }

    function deleteAdmin($id)
    {
        if (checkAdmin($id)) {
            Admin::where('id', $id)->delete();
            session()->flash('msg', 'تم حذف المدير');
        }
        return redirect()->back();
    }

    function activateAdmin($id)
    {
        if (checkAdmin($id)) {
            Admin::where('id', $id)->update(['active' => 1]);
            session()->flash('msg', 'تم تفعيل حساب المدير');
        }
        return redirect()->back();
    }

    function deActivateAdmin($id)
    {
        if (checkAdmin($id)) {
            Admin::where('id', $id)->update(['active' => 0]);
            session()->flash('msg', 'تم الغاء تفعيل حساب المدير');
        }
        return redirect()->back();
    }

    function permission(Request $request)
    {
        $q = (isset($request['q'])) ? $request['q'] : '';
        $data['groups'] = group_permission::where('name', 'like', '%' . $q . '%')->paginate(20);
        $data['q'] = $q;

        return view('admin.control.permission', $data);
    }

    function newGroup(Request $request)
    {
        $data['controllers'] = \App\controller::orderBy('order', 'asc')
            ->with('fun')->get();
        return view('admin.control.newGroup', $data);
    }

    function newGroupPost(Request $request)
    {
        $group = new group_permission();
        $group->name = $request['name'];
        $group->save();
        $data = [];
        foreach ($request['functions'] as $function) {
            $data[] = array(
                'PermissionGroup_id' => $group->id,
                'function_id' => $function
            );
        }

        \App\permission::insert($data);
        session()->flash('msg', 'تم انشاء مجموعة صلاحيات جديدة');
        return redirect('/admin/control/permission');
    }

    function editGroup($id)
    {
        if ($id == 1)
            return redirect('/admin/notAuth');
        $data['group'] = group_permission::find($id);
        $data['controllers'] = \App\controller::orderBy('order', 'asc')
            ->with(['fun' => function ($query) use ($id) {
                $query->leftJoin('permission as gp', function ($join) use ($id) {
                    $join->on('gp.function_id', '=', 'function.id')
                        ->on('gp.PermissionGroup_id', DB::raw($id));
                })->select('function.*', DB::raw('gp.id is not null havePermission'));
            }])
            ->get();

        return view('admin.control.editGroup', $data);
    }

    function deleteGroup($id)
    {

        $check = \App\admin::where('permission_group', $id)->count();
        if ($check == 0) {
            \App\permissionGroup::where('id', $id)->delete();
            session()->flash('msg', 'تم حذف المجموعة بنجاح');
            return redirect()->back();
        }
        session()->flash('msg', 'لايمكن حذف هذه المجموعة لاحتوائها على مستخدمين');
        return redirect()->back();
    }

    function editGroupPost(Request $request)
    {
        if ($request->id == 1)
            abort(404);
        else {
            $group = group_permission::find($request['id']);
            $group->name = $request['name'];
            $group->save();
            $data = [];
            \App\permission::where('PermissionGroup_id', $request['id'])->delete();
            foreach ($request['functions'] as $function) {
                $data[] = array(
                    'PermissionGroup_id' => $group->id,
                    'function_id' => $function
                );
            }

            \App\permission::insert($data);
            session()->flash('msg', 'تم تعديل مجموعة الصلاحيات');
            return redirect()->back();
        }
    }

    function settings()
    {
        return view('admin.control.settings');
    }

    function settingsPosts(Request $request)
    {

        $this->validate($request, [
            'site_rate' => 'between:0.00,1.00|numeric',
        ]);

        switch ($request['type']) {
            case 'info':
                $param = $request->only(['siteName', 'siteTitle', 'description', 'cu_email', 'contact_email', 'home_header_text', 'Keywords']);
                foreach ($param as $key => $value) {
                    setting::add($key, $value);
                }
                session()->flash('msg', 'تم تعديل بيانات الموقع بنجاح');
                return redirect('/admin/control/settings')->with('info','active');
                break;

            case 'settings':
                $param = $request->only(['open_project_day', 'site_rate', 'open_bids', 'suspended_balance_day']);
                foreach ($param as $key => $value) {
                    setting::add($key, $value);
                }
                session()->flash('msg', 'تم تعديل إعدادات المشاريع بنجاح');
                return redirect('/admin/control/settings')->with('settings','active');
                break;

            case 'footer':
                $param = $request->only(['android', 'ios', 'twitter', 'facebook', 'google', 'linkedin', 'copyRights_text', 'footer_text', 'siteLicense']);
                foreach ($param as $key => $value) {
                    setting::add($key, $value);
                }
                session()->flash('msg', 'تم تعديل بيانات الفوتر بنجاح');
                return redirect('/admin/control/settings')->with('footer','active');
                break;

            case 'super':
                $param = $request->only(['super_header_text', 'super_video_url', 'super_paragraph', 'vip_email']);
                foreach ($param as $key => $value) {
                    setting::add($key, $value);
                }
                session()->flash('msg', 'تم تعديل بيانات السوبر بنجاح');
                return redirect('/admin/control/settings')->with('super','active');
                break;
        }
        if (!isset($param)){
            session()->flash('msg', 'الرجاء التأكد من العملية');
            return redirect('/admin/control/settings');
        }

    }

    function statistic()
    {
        $users = \App\user::count();
        $project = \App\project::count();
        $bid = \App\bid::count();
        $descution = \App\projectDescussion::count();
        $conversation = \App\conversation::count();
        $reports = \App\report::count();
        $vipProjects = \App\VIPRequest::count();
        $portfolio = \App\portfolio::count();
        $transactions = \App\transaction::count();
        return view('admin.statistic', compact('transactions','portfolio','vipProjects','reports','users', 'project', 'descution', 'bid', 'conversation'));
    }
}
