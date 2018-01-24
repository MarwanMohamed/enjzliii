<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class project extends Model
{

    protected $fillable = ['isView'];
    
    protected $table = 'projects';

    function reports()
    {
        return $this->hasMany('App\report', 'refer_id')->where('type', 2);
    }

    function bids()
    {
        return $this->hasMany('App\bid');
    }

    function specialization()
    {
        return $this->belongsTo('App\specialization');
    }

    function file()
    {
        return $this->hasMany('App\file', 'refer_id')->where('referal_type', 3);
    }

    function skills()
    {
        return $this->hasMany('App\projectskills');
    }

    function budget()
    {
        return $this->hasOne('App\projectBudget', 'id', 'budget_id');
    }

    function owner()
    {
        return $this->hasOne('App\user', 'id', 'projectOwner_id');
    }


    function VIPOwner()
    {
        return $this->hasOne('App\user', 'id', 'VIPUser');
    }


    function caneclProject()
    {
        return $this->hasOne('App\caneclProject');
    }

    function VIP()
    {
        return $this->hasOne('App\user', 'id', 'VIPUser');
    }

    function freelancers()
    {
        return $this->hasMany('App\projectFreelancer', 'project_id', 'id');
    }

    function freelancer()
    {
        return $this->hasMany('App\projectFreelancer', 'project_id', 'id')->where(function ($q) {
            $q->where('status', 1)->orWhere('status', 3);
        });
    }

    function favorite()
    {
        return $this->hasOne('App\favorite', 'refer_id', 'id')->where('type', 2);
    }

    function isClose()
    {
        global $setting;
        $status = $this->status;
        if ($this->status == 2) {
            if (session('user')) {
                if ($status || session('user')['status'] == 1) {
                    $date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at);
                    $now = \Carbon\Carbon::now();
                    if ($now->diffInDays($date) > $setting['open_project_day']) {
//             project close
                        return 'هذا المشروع مغلق لتعدي الفترة المسموحة للمشاريع المفتوحة';
                    } else {
                        return 0;
                    }
                } else {
                    return 'تم حظر حسابك الرجاء مراجعة الإدارة';
                }
            } else {
//            must login
                return 'أنت غير مسجل دخولك لدينا في الوقت لحالي، لتقديم عرضك يرجى <a href="/register">التسجيل</a> أو <a href="/login">تسجيل الدخول</a>';
            }
        } else if ($status == 3) {
            return 0;
        } else {
//        submited close
            return 'المشروع مغلق';
        }
    }

    function isOpen()
    {
        global $setting;

        $date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at);
        $now = \Carbon\Carbon::now();
        if ($now->diffInDays($date) <= $setting['open_project_day'] && $this->status == 2) {
            return 1;
        }
        return 0;
    }

    static function fillter($id, $q = '')
    {

        global $setting;
//        if ($id == 2) {
        $cancelProjects = \App\caneclProject::pluck('project_id')->toArray();
        $date = Carbon::now();
        $before = $date->subDay($setting['open_project_day']);
        $open_project_day = \App\setting::where('set_id', 'open_project_day')->first(['set_data'])->set_data;

        if ($id == 2) {

            $projects = project::whereNotIn('id', $cancelProjects)->where('isBlock', 0)->where(function ($q) {
                $q->where('projectOwner_id', session('user')['id'])->orWhere('VIPUser', session('user')['id']);
            })
                ->with('bids')->with('budget')
                ->latest()
                ->where('status', 2)->where('projects.isBlock', 0)->whereRaw("(created_at + INTERVAL + {$open_project_day} DAY) > NOW()")
                ->where('title', 'like', '%' . $q . '%');
        } else if ($id == 4) {
            $projects = project::where('isBlock', 0)->where('projectOwner_id', session('user')['id'])
                ->with('bids')->with('budget')
                ->latest()
                ->where('status', 4)
                ->where('title', 'like', '%' . $q . '%');
        } else if ($id == 5) {
            $projects = project::whereNotIn('id', $cancelProjects)->where('isBlock', 0)->where('projectOwner_id', session('user')['id'])
                ->with('bids')->with('budget')
                ->latest()
                ->where('status', 2)->whereRaw("(created_at + INTERVAL + {$open_project_day} DAY) < NOW()")->orWhere('status', 5)->whereRaw("(created_at + INTERVAL + {$open_project_day} DAY) < NOW()")
                ->where('title', 'like', '%' . $q . '%');
        } else if ($id == 7) {
            $projects = project::whereNotIn('id', $cancelProjects)->where('isBlock', 1)->where('projectOwner_id', session('user')['id'])
                ->with('bids')->with('budget')
                ->latest()
                ->where('title', 'like', '%' . $q . '%');
        } else {
            $projects = project::whereNotIn('id', $cancelProjects)->where('isBlock', 0)->where('projectOwner_id', session('user')['id'])
                ->with('bids')->with('budget')
                ->latest()
                ->where('status', $id)
                ->where('title', 'like', '%' . $q . '%');
        }
//        }
//        else {
//            $projects = project::where('isBlock',0)->where('projectOwner_id', session('user')['id'])
//                    ->with('bids')->with('budget')
//                    ->where('status', $id)
//                    ->where('title', 'like', '%' . $q . '%')
//                    ->latest()
//                    ->paginate(6);
//        }
        return $projects;
    }

    static function openProjectCount()
    {
        global $setting;
        $date = Carbon::now();
        $before = $date->subDay($setting['open_project_day']);
        return project::where('status', 2)
            ->where('created_at', '>=', $before->toDateTimeString())
            ->orWhere('status', 3)
            ->count();
    }

    static function openProject($request = [])
    {
        global $setting;
        $date = Carbon::now();
        $before = $date->subDay($setting['open_project_day']);
        $query = project::where('status', 2)->where('isBlock', 0)
            ->where('created_at', '>=', $before->toDateTimeString())
            ->with('owner')
            ->with('bids')
            ->with('favorite')
            ->latest()
            ->where('isPrivate', 0)
            ->orderBy('IsVIP')
            ->with('budget');

        if ($request->q) {
            $q = $request->q;
            $query->where(function ($query) use ($q) {
                $query->where('title', 'like', '%' . $q . '%')->orWhere('description', 'like', '%' . $q . '%');
            });
        }
        if ($request->deliveryDuration) {
            $deliveryDuration = $request->deliveryDuration;
            $rs = minMaxday($deliveryDuration);
            $query->where(function ($query) use ($rs) {
                $query->where('deliveryDuration', '>=', $rs['min'])->where('deliveryDuration', '<=', $rs['max']);
            });
        }
        if (!empty($request->specialization_id)) {
            $query->where('specialization_id', $request->specialization_id);
        }
        if ($request->skills) {
            $skills = $request->skills;
            if (is_array($skills)) {
                $query->whereHas('skills', function ($query) use ($skills) {
                    $query->whereIn('skill_id', $skills);
                });
            }
        }
        if ($request->budget) {
            $budget = explode(';', $request->budget);
            $query->whereHas('budget', function ($query) use ($budget) {
                if (sizeof($budget) == 2)
                    $query->where('min', '>=', $budget[1])->where('max', '<=', $budget[0]);
            });
        }


        return $query->paginate(10);
    }

    static function finishTime()
    {
        $projects = DB::table('caneclproject as cp')
            ->leftJoin('projects as p', 'p.id', '=', 'cp.project_id')
            ->leftJoin('user as u', 'u.id', '=', 'p.projectOwner_id')
            ->select('p.*', 'u.username', 'u.fname', 'u.lname', 'u.id as user_id', 'cp.id as isCancel')
            ->orderBy('cp.id', 'desc')
            ->paginate(10);

//            DB::table('projects as p')->leftJoin('projectfreelancer as pf',function($q){
//            $q->on('p.id','pf.project_id')->on('pf.status', \DB::raw(1));
//        })
//            ->leftJoin('user as u','u.id','=','p.projectOwner_id')
//                ->select('p.*','u.username','u.fname','u.lname','u.id as user_id','pf.freealancerFinish','cp.id as isCancel')
//                ->where('pf.created_at','>','DATEADD(day,-(pf.deliveryDuration+1),CURDATE())')
//                ->orWhere(function($q){
//                    $q->where('pf.freealancerFinish')->where('pf.created_at','>','DATEADD(day,-(2),CURDATE())');
//                })
//            ->leftJoin('caneclproject as cp','cp.project_id','p.id')
//                ->paginate(10);

        return ($projects);
    }


    function getAllProjects($id = 0, $fillterTime = 0, $fillterType = 0)
    {
        $order = ($fillterTime) ? 'asc' : 'desc';

        $query = project::where(function ($q) {
            $q->where('projectOwner_id', session('user')['id'])->orWhere('VIPUser', session('user')['id']);
        })
            ->with('bids')->with('budget');
        if (!empty($fillterType) && $fillterType != 5)
            $query->where('projects.status', $fillterType);

        if ($fillterType == 5) {

            $query->where('projects.status', $fillterType);
            $date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at);
            $now = \Carbon\Carbon::now();
            $open_project_day = \App\setting::where('set_id', 'open_project_day')->first(['set_data'])->set_data;
            if ($now->diffInDays($date) > $open_project_day) {

            }
        }


        $projects = $query->orderBy('projects.id', $order)
            ->paginate(8);

        return $projects;
    }

    function getAll($id = 0, $fillterTime = 0, $fillterType = 0)
    {
        $order = ($fillterTime) ? 'asc' : 'desc';

        if ($id != 0) {
            $query = project::where(function ($q) use ($id) {
                $q->where('projectOwner_id', $id)->orWhere('VIPUser', $id);
            })
                ->with('bids')->with('budget');
        } else {
            $query = project::where(function ($q) {
                $q->where('projectOwner_id', session('user')['id'])->orWhere('VIPUser', session('user')['id']);
            })
                ->with('bids')->with('budget');
        }

        if (!empty($fillterType) && $fillterType != 5)
            $query->where('projects.status', $fillterType);

        if ($fillterType == 2) {
            $open_project_day = \App\setting::where('set_id', 'open_project_day')->first(['set_data'])->set_data;
            $query->where('projects.status', 2)->where('projects.isBlock', '!=', 1)->whereRaw("(created_at + INTERVAL + {$open_project_day} DAY) > NOW()");
        }
        if ($fillterType == 5) {

            $open_project_day = \App\setting::where('set_id', 'open_project_day')->first(['set_data'])->set_data;
            $query->where('projects.status', 2)->whereRaw("(created_at + INTERVAL + {$open_project_day} DAY) < NOW()")->orWhere('projects.status', 5)->whereRaw("(created_at + INTERVAL + {$open_project_day} DAY) < NOW()");

        }


        $projects = $query->orderBy('projects.id', $order)
            ->paginate(8);

        return $projects;
    }
}
