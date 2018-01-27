<?php

namespace App\Http\Controllers\admin;

use App\contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \DB;

class messages extends Controller
{

    //


    function index($id = 0, Request $request)
    {
        $q = $request->q ? $request->q : '';
        $type = $request->type ? $request->type : '';

        $messages = contact::latest()->with('problem');
        if ($q) {
            $messages->where('title', 'like', '%' . $q . '%')->orWhere('email', 'like', '%' . $q . '%')->orWhere('message', 'like', '%' . $q . '%');
        }
        if ($type) {
            if ($type != 0) {
                $messages->whereHas('problem', function ($q) use ($type) {
                    $q->where('id', $type);
                });
            }
            }
            $messages = $messages->paginate(10);
            $tibs = \App\tibs::where('type', 3)->get()->pluck('value', 'id')->prepend('الكل', 0);
            return view('admin/messages/index', compact('messages', 'tibs', 'q','type'));
        }

        function statistic()
        {
            $lastDay = \Carbon\Carbon::today();
            $day = contact::where('created_at', '>', $lastDay)->count();
            $week = contact::where('created_at', '>', $lastDay->subWeeks(1))->count();
            $month = contact::where('created_at', '>', $lastDay->subMonths(1))->count();
            $now = \Carbon\Carbon::now();

            $all = contact::count();
            $grouped = contact::select(DB::raw('DATE(created_at) as date, DAY(created_at) as day'), DB::raw('count(*) as count'))
                ->groupBy('date')
                ->where('created_at', '>', $lastDay->subMonths(1))
                ->get()->pluck('count', 'day')->toArray();
            $last5 = contact::limit(5)->latest()->get();

            return view('admin/messages/statistic', compact('day', 'month', 'week', 'all', 'grouped', 'last5'));

        }

        function single($id)
        {
            $message = contact::where('id', $id)
                ->first();
            $message->update(['isView' => 1]);
            if ($message) {
                contact::where('id', $id)->update(['seen' => 1]);
                $setting['messages'] = \App\contact::where('seen', 0)->limit(10)->get();

                return view('admin.messages.single', compact('message'));
            } else {
                $this->error('هذا الرسالة غير موجود');
            }
        }

        function block(Request $request)
        {
            $this->validate($request, [
                'id' => 'required|integer',
                'blockReason' => 'required|min:20|max:500',
            ]);
            $id = $request->id;
            bid::where('id', $id)->update(['isBlock' => 1, 'blockReason' => $request->blockReason]);
            session()->flash('msg', 'تم حظر العرض');
            $bid = bid::find($id);
            if ($bid)
                notifcation::addNew(1, 0, $bid->project->projectOwner_id, 'رسالة ادارية', 'تم حظر عرضك على مشروع' . $bid->project->title . ' لمزيد من المعلومات راجع الإدارة.', 0);
            //this new  added by me
            /////////////////////////////////////////////////
            $user = \App\user::find($bid->project->projectOwner_id);
            if (!empty($user->device_token)) {
                $m1 = ['en' => 'تم حظر عرضك على مشروع' . $bid->project->title . ' لمزيد من المعلومات راجع الإدارة.'];
                $url = url('/') . '/project/' . $bid->project->id . '-' . $bid->project->title;
                sendNotification($m1, $user->device_token, 'project', $url);
            }
            //////////////////////////////////////////////////
            return redirect(redirect()->back()->getTargetUrl());
        }

        function unblock($id)
        {
            bid::where('id', $id)->update(['isBlock' => 0]);
            session()->flash('msg', 'تم تفعيل العرض');
            $bid = bid::find($id);
            if ($bid)
                notifcation::addNew(1, 0, $bid->project->projectOwner_id, 'رسالة ادارية', 'تم الغاء حظر عرضك على مشروع  ' . $bid->project->title . ' لمزيد من المعلومات راجع الإدارة.', 0);

            //this new  added by me
            /////////////////////////////////////////////////
            $user = \App\user::find($bid->project->projectOwner_id);
            if (!empty($user->device_token)) {
                $m1 = ['en' => 'تم الغاء حظر عرضك على مشروع  ' . $bid->project->title . ' لمزيد من المعلومات راجع الإدارة.'];
                $url = url('/') . '/project/' . $bid->project->id . '-' . $bid->project->title;
                sendNotification($m1, $user->device_token, 'project', $url);
            }
            //////////////////////////////////////////////////
            return redirect(redirect()->back()->getTargetUrl());
        }

    }
