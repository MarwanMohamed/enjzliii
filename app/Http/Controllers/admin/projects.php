<?php

namespace App\Http\Controllers\admin;

use App\bid;
use App\country;
use App\link;
use App\notifcation;
use \Illuminate\Support\Facades\DB;
use App\portfolio;
use App\project;
use App\setting;
use App\skill;
use Validator;
use App\user;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\adminLog;

class projects extends Controller
{

    //
    function needRevision(Request $request)
    {
        $q = $request->q ? $request->q : '';
        $data['projects'] = project::where('status', 1)->where(function ($query) use ($q) {
            $query->where('title', 'like', '%' . $q . '%')->orWhere('description', 'like', '%' . $q . '%');
        })->paginate(10);

        $orderBy = $request->orderBy ? $request->orderBy : 'id';
        $orderByType = $request->asc ? 'asc' : 'desc';


        $data['q'] = $q;
        $data['searchParam'] = 'q=' . $q;
        $data['orderBy'] = $orderBy;
        $data['orderByType'] = $orderByType;
        return view('admin/projects/needRevision', $data);
    }

    function approve($id)
    {
        project::where('id', $id)->update(['status' => 2, 'created_at' => \Carbon\Carbon::now()]);
        $project = project::find($id);
        $project->update(['isView' => 1]);

        session()->flash('msg', 'تم الموافقة على المشروع');
        notifcation::addNew(12, $project->id, $project->projectOwner_id, 'الموافقة على مشروعك', 'تم الموافقة على مشروع:  ' . $project->title . ' من قبل الإدارة', 0);
        $notifications = notifcation::where('project_id',$project->id)->get();

        foreach ($notifications as $n) {
            $user = \App\user::find($n->user_id);
            if (!empty($user->device_token)) {
                $m1 = ['en' => ' تم دعوتك لاضافة عرض على مشروع خاص.  ' . $n->project->title];
                $url = url('/') . '/project/' . $n->project->id . '-' . $n->project->title;
                sendNotification($m1, $user->device_token, 'project', $url);
            }
        }
          notifcation::where('project_id',$project->id)->update(['project_id'=>0,'created_at'=>\Carbon\Carbon::now()]);

        //this new  added by me
        /////////////////////////////////////////////////
        $user = \App\user::find($project->projectOwner_id);
        if (!empty($user->device_token)) {
            $m1 = ['en' => 'تم الموافقة على مشروع:  ' . $project->title . ' من قبل الإدارة'];
            $url = url('/').'/project/'.$project->id.'-'.$project->title;
            sendNotification($m1, $user->device_token, 'project',$url);
        }
        /////////////////////////////////////////////////
        adminLog::addPR($id, 'APV', 'تم الموافقة على المشروع');
        return redirect('/admin/projects/needRevision');
    }


    function statistic()
    {
        $lastDay = \Carbon\Carbon::today();
        $day = project::where('created_at', '>', $lastDay)->get();
        $week = project::where('created_at', '>', $lastDay->subWeeks(1))->get();
        $month = project::where('created_at', '>', $lastDay->subMonths(1))->get();

        $all = project::get();
        $grouped = project::select(DB::raw('DATE(created_at) as date, DAY(created_at) as day'), DB::raw('count(*) as count'))
            ->groupBy('date')
            ->where('created_at', '>', $lastDay->subMonths(1))
            ->get()->pluck('count', 'day')->toArray();
        return view('admin/projects/statistic', compact('day', 'month', 'week', 'all', 'grouped'));

    }


    function index(Request $request)
    {
        $q = $request->q ? $request->q : '';
        $owner = $request->owner ? $request->owner : '';
        $words = explode(' ', $q);
        $ownerWords = explode(' ', $owner);
        $columnSearchUser = ['username', 'fname', 'lname', 'email'];
        $columnSearchProject = ['title', 'description'];
        $status = $request->status ? $request->status : 0;
        $status = ($status > 1 && $status <= 7) ? $status : 0;
        $orderBy = $request->orderBy ? $request->orderBy : 'id';
        $orderByType = $request->asc ? 'asc' : 'desc';
        $orderByExisit = array_search($orderBy, ['username', 'created_at', 'lastLogin', 'status']);

        if ($orderByExisit === false)
            $orderBy = 'id';


        $query = project::orderBy($orderBy, $orderByType)
            ->where(function ($qe) use ($columnSearchProject, $q) {
                foreach ($columnSearchProject as $column)
                    $qe->orWhere($column, 'like', '%' . $q . '%');
        });

        if (sizeof($ownerWords)) {
            $query->whereHas('owner', function ($q) use ($ownerWords, $columnSearchUser) {
                $q->whereRaw('0=1');
                foreach ($ownerWords as $word) {
                    foreach ($columnSearchUser as $column)
                        $q->orWhere($column, 'like', '%' . $word . '%');
                }
            });
        }
        $query->where('status', '<>', 1);
        if ($status) {
            if ($status == 5) {
                global $setting;
                $date = \Carbon\Carbon::now();
                $before = $date->subDay($setting['open_project_day']);
                $query->where('status', 2)->where('created_at', $before->toDateTimeString());
            } else if ($status == 7)
                $query->where('isBlock', 1);
            else
                $query->where('status', $status);
        }

        $data['projects'] = $query->paginate(10);

        $data['projects']->withPath(url()->full());
        $data['q'] = $q;
        $data['owner'] = $owner;
        $data['status'] = $status;
        $data['orderBy'] = $orderBy;
        $data['orderByType'] = $orderByType;
        $data['searchParam'] = "q=$q&status=$status&status=$status&";
        $data['orderParam'] = "orderBy=$orderBy&orderByType=$orderByType&";
        session(['searchParam' => $data['searchParam'], 'orderParam' => $data['orderParam']]);


        return view('admin/projects/index', $data);
    }

    function singleUser($id = 0)
    {
        $data['user'] = user::profile($id);
        if (sizeof($data['user'])) {
            $data['statistics'] = $statistics = user::Statistics($id);
            $data['evaluates'] = user::getEvaluate($id);
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

    function cancel(Request $request)
    {

        if(!$request->has('mMethod')){
        $project = project::where('id', $request->id)->first();

        $id = $request->id;
        if (!$project) {
            session()->flash('msg', 'هذا المشروع غير موجود');
        } else if ($project->status == 3 || $project->status == 4) {
            if ($request->ownerRate && $request->ownerRate >= 0 && $request->ownerRate < 100) {
                $bid = bid::where('project_id', $id)->where('status', 2)->first();
                bid::where('project_id', $request->id)->update(['status' => 4]);
                \App\projectFreelancer::where('id', $project->freelancer[0]->id)->update(['status' => 2]);
                $transactionType = 1;
                $processType = 1;
                if ($request->ownerRate != 100)
                    \App\transaction::transfer($project->projectOwner_id, $project->freelancer[0]->freelancer_id, $bid->cost * (1 - ($request->ownerRate / 100)), $bid->dues * (1 - ($request->ownerRate / 100)), $processType, $transactionType);
                user::where('id', $project->projectOwner_id)->update(['balance' => DB::raw('balance-' . $bid->cost * ($request->ownerRate / 100)), 'suspended_balance' => DB::raw('suspended_balance-' . $bid->cost)]);
                user::where('id', $project->freelancer[0]->freelancer_id)->update(['balance' => DB::raw('balance+' . $bid->dues * (1 - ($request->ownerRate / 100))), 'suspended_balance' => DB::raw('suspended_balance+' . $bid->dues * (1 - ($request->ownerRate / 100)))]);
                notifcation::addNew(7, $id, $project->freelancer[0]->freelancer_id, 'الغاء المشروع', 'لقد حصلت على نسبة ' . (100 - $request->ownerRate) . '% من تكلفة المشروع', 0);
                notifcation::addNew(7, $id, $project->projectOwner_id, 'الغاء المشروع', 'لقد حصلت على نسبة ' . ($request->ownerRate) . '% من تكلفة المشروع', 0);

                //this new  added by me
                /////////////////////////////////////////////////
                $user1 = \App\user::find($project->projectOwner_id);
                if (!empty($user1->device_token)) {
                    $m1 = ['en' => 'لقد حصلت على نسبة ' . ($request->ownerRate) . '% من تكلفة المشروع'];
                    $url = url('/') . '/project/' . $bid->project->id . '-' . $bid->project->title;
                    sendNotification($m1, $user1->device_token, 'project', $url);
                }
                $user2 = \App\user::find($project->freelancer[0]->freelancer_id);
                if (!empty($user2->device_token)) {
                    $m2 = ['en' => 'لقد حصلت على نسبة ' . (100 - $request->ownerRate) . '% من تكلفة المشروع'];
                    $url = url('/') . '/project/' . $bid->project->id . '-' . $bid->project->title;
                    sendNotification($m2, $user2->device_token, 'project', $url);
                }
                ////////////////////////////////////////////////

                project::where('id', $id)->update(['status' => 4, 'blockReason' => $request->blockReason]);

                \App\caneclProject::where('project_id',$project->id)->delete();

                adminLog::addPR($id, 'CNL', 'تم الغاء المشروع');
                session()->flash('msg', 'تم الغاء المشروع');
            } else {
                session()->flash('حصل خطأ');
            }

        } else {
            session()->flash('msg', 'تم الغاء المشروع');
            adminLog::addPR($id, 'CNL', 'تم الغاء المشروع');
            project::where('id', $id)->update(['status' => 4, 'blockReason' => $request->blockReason]);
            notifcation::addNew(7, $id, $project->projectOwner_id, 'الغاء المشروع', 'لقد تم الغاء المشروع من قبل الإدارة', 0);

            //this new  added by me
            /////////////////////////////////////////////////
            $user = \App\user::find($project->projectOwner_id);
            if (!empty($user->device_token)) {
                $m1 = ['en' => 'لقد تم الغاء المشروع :  ' . $project->title . ' من قبل الإدارة '];
                $url = url('/') . '/project/' . $project->id . '-' . $project->title;
                sendNotification($m1, $user->device_token, 'project', $url);
            }
            ///////////////////////////////////////////////
        }
            \App\report::where('type', 2)->where('refer_id', $id)->update(['status' => 1]);

            if ($request->cancel)
                return redirect('admin/projects/needRevision?' . session('searchParam') . '&' . session('orderSearch'));
            else
                return redirect(url()->previous());

        }else{
            $project = project::where('id',  $request['project_id'])->first();

            project::where('id', $request['project_id'])->update(['status' => 3, 'isBack' => 1]);

            \App\caneclProject::where('project_id', $request['project_id'])->delete();
            notifcation::addNew(1, 0, $project->projectOwner_id, 'رسالة ادارية', 'تم إستناف العمل بمشروعك' . $project->title . ' لمزيد من المعلومات راجع الإدارة.', 0);

            //this new  added by me
            /////////////////////////////////////////////////
            $user = \App\user::find($project->projectOwner_id);
            if (!empty($user->device_token)) {
                $m1 = ['en' => 'تم إستناف العمل بمشروعك :  ' . $project->title . ' من قبل الإدارة '];
                $url = url('/') . '/project/' . $project->id . '-' . $project->title;
                sendNotification($m1, $user->device_token, 'project', $url);
            }

            return back()->with('msg','تمت العملية بنجاح');
        }
    }

    function block(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'blockReason' => 'required|min:20|max:500',
        ]);

        if ($validator->fails()) {
            session()->flash('errors', $validator->errors());
        } else {
            project::where('id', $request->id)->update(['isBlock' => 1, 'blockReason' => $request->blockReason]);
            session()->flash('msg', 'تم حظر المشروع');

            adminLog::addPR($request->id, 'BLK', 'تم حظر المشروع بسبب :' . $request->blockReason);
            $project = project::where('id', $request->id)->first();
            notifcation::addNew(1, 0, $project->projectOwner_id, 'رسالة ادارية', 'تم حظر مشروع ' . $project->title . ' لمزيد من المعلومات راجع الإدارة.', 0);
            if (sizeof($project->freelancer))
                notifcation::addNew(1, 0, $project->freelancer[0]->freelancer_id, 'رسالة ادارية', 'تم حظر مشروع ' . $project->title . ' لمزيد من المعلومات راجع الإدارة.', 0);

            //this new  added by me
            /////////////////////////////////////////////////
            $user1 = \App\user::find($project->projectOwner_id);
            if (!empty($user1->device_token)) {
                $m1 = ['en' => 'تم حظر مشروع ' . $project->title . ' لمزيد من المعلومات راجع الإدارة.'];
                $url = url('/').'/project/'.$project->id.'-'.$project->title;
                sendNotification($m1, $user1->device_token, 'project',$url);
            }
            if (sizeof($project->freelancer)) {
                $user2 = \App\user::find($project->freelancer[0]->freelancer_id);
                if (!empty($user2->device_token)) {
                    $m2 = ['en' => 'تم حظر مشروع ' . $project->title . ' لمزيد من المعلومات راجع الإدارة.'];
                    $url = url('/').'/project/'.$project->id.'-'.$project->title;
                    sendNotification($m2, $user2->device_token, 'project',$url);
                }
            }
            ////////////////////////////////////////////////////
        }
        return redirect('admin/projects');
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
            notifcation::addNew(1, 0, $request->id, $request->text, 0);
            session()->flash('msg', 'تم ارسال رسالة ادارية');
        }
        return redirect('admin/users');
    }

    function unblock($id)
    {
        project::where('id', $id)->update(['isBlock' => 0]);
        session()->flash('msg', 'تم تفعيل المشروع');
        $project = project::find($id);

        notifcation::addNew(1, 0, $project->projectOwner_id, 'رسالة ادارية', 'تم الغاء حظر مشروع ' . $project->title . ' لمزيد من المعلومات راجع الإدارة.', 0);

        //this new  added by me
        /////////////////////////////////////////////////
        $user = \App\user::find($project->projectOwner_id);
        if (!empty($user->device_token)) {
            $m1 = ['en' => 'لقد تم الغاء حظر مشروع :  ' . $project->title];
            $url = url('/').'/project/'.$project->id.'-'.$project->title;
            sendNotification($m1, $user->device_token, 'project',$url);
        }
        //////////////////////////////////////////////////

        adminLog::addPR($id, 'UBK', 'تم الغاء حظر المشروع');

        return redirect('admin/projects');
    }

    function single($id)
    {
        $project = project::where('id', $id)
            ->with('owner')
            ->withCount('bids')
            ->with('specialization')
            ->with('budget')
            ->with('file')
            ->first();
         $data['cost'] = \App\projectFreelancer::where('project_id',$id)->first(['cost']);
        if ($project) {
            $project->update(['isView' => 1]);
            $data['project'] = $project;
            return view('admin.projects.single', $data);
        } else {
            $this->error('هذا المشروع غير موجود');
        }
    }


    function errors(Request $request)
    {
        $q = $request->q ? $request->q : '';
        $projects = project::finishTime();
        return view('admin.projects.errors', compact('projects', 'q'));
    }
}
