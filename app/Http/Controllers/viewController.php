<?php

namespace App\Http\Controllers;

use App\bid;
use App\bidTibs;
use App\conversation;
use App\country;
use App\evaluate;
use App\favorite;
use App\message;
use App\notifcation;
use App\portfolio;
use App\project;
use App\projectBudget;
use App\projectDescussion;
use App\projectskills;
use App\report;
use App\EditPrice;
use App\reportreason;
use App\setting;
use App\skill;
use App\file;
use App\specialization;
use App\tibs;
use App\transaction;
use App\user;
use App\page;
use App\FAQ;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;
use Response;
use Illuminate\Http\Request;

class viewController extends Controller
{

    //

    function index()
    {

        $data['freelancers'] = user::where('type', 2)->orWhere('type', 3)->count();
        $data['activeProject'] = project::openProjectCount();
        $data['finishProject'] = project::where('status', 6)->count();
        $data['transactions'] = transaction::count();
        if (session('user')) {
            return redirect('/singleUser');
        }
        return view('front.index', $data);
    }

    function index1()
    {

        $red = null;

        if (session('user')) {
            $red = redirect('/singleUser/' . session('user')['id']);
        } else {
            $red = view('index');
        }
        return $red;
    }

    function login()
    {
        $countries = \App\country::get();
        return view('front.login', compact('countries'));
    }

    function register()
    {
        global $setting;
        if (!$setting['users_isClose']) {
            $data['countries'] = country::get();
            return view('front.register', $data);
        } else {
            session()->flash('msg', 'تم ايقاف التسجيل موقتا');
            return redirect('/login');
        }
    }

    function page($name)
    {
        $page = page::where('url', $name)->first();
        if ($page) {
            $data['page'] = $page;
            return view('front.page', $data);
        } else {
            abort(404);
        }
    }

    function notifcations()
    {

        $data['notifcations'] = notifcation::where('user_id', session('user')['id'])->latest()
            ->with('owner')->paginate(10);
        notifcation::where('user_id', session('user')['id'])->update(['seen' => 1]);
        if (request()->ajax()) {
            $json['status'] = 1;
            $json['view'] = view('my.notifcation', $data)->render();
            return response()->json($json);
        }
        $data['user'] = user::profile(session('user')['id']);
        return view('my.notifactions', $data);
    }

    function notifcationSeen($id)
    {
        notifcation::where('user_id', session('user')['id'])->where('id', $id)->update(['seen' => 1]);

        $templateData['notifcations'] = notifcation::where('user_id', session('user')['id'])->latest()->paginate(10);

        $unseen = 0;
        foreach ($templateData['notifcations'] as $value) {
            if (!$value->seen)
                $unseen++;
        }
        $templateData['unseenNoti'] = $unseen;
        $data['templateData'] = $templateData;
        $json['view'] = view('front.notifcation', $data)->render();
        $json['status'] = 1;
        $json['unseen'] = $unseen;
        $json['textType'] = 'notifaction';
        return response($json);
    }

    function FAQ()
    {
        $data['faq'] = FAQ::orderBy('ordered')->where('isVIP', 0)->get();
        return view('front.faq', $data);
    }

    function Contact()
    {
        $data['problems'] = tibs::where('type', 3)->get();
        return view('front.contact', $data);
    }

    function getNew(Request $request)
    {
        $templateData['messages'] = \App\conversation::whereHas('messages', function ($q) {
            $q->where('reciever_id', session('user')['id'])
                ->orWhere('VIPUser', session('user')['id']);
        })->with(['messages', 'messages.sender'])->latest()->limit(10)->get();

        $unseen = 0;
        foreach ($templateData['messages'] as $value) {
            if (session('user')['isVIP']) {
                if ($value->messages->last()->VIPSeen === 0)
                    $unseen++;
            } else {
                if (!$value->messages->last()->seen && $value->messages->last()->reciever_id == session('user')['id'])
                    $unseen++;
            }
        }
        $templateData['unseen'] = $unseen;

        $data['templateData'] = $templateData;
        $json['message'] = view('front.message', $data)->render();
        $json['status'] = 1;

        $templateData['notifcations'] = notifcation::where('user_id', session('user')['id'])->latest()->paginate(10);

        $unseen = 0;
        foreach ($templateData['notifcations'] as $value) {
            if (!$value->seen)
                $unseen++;
        }
        $templateData['unseenNoti'] = $unseen;
        $data['templateData'] = $templateData;
        $json['notifaction'] = view('front.notifcation', $data)->render();
        return response()->json($json);
    }

    function forgetPassword()
    {
        return view('front.forgetPassword');
    }

    function error(Request $request)
    {
        $request->session()->reflash();
        return view('front/msg');
    }

    function viewError($msg = 'حصل خطأ ما')
    {
        return view('front/msg', array('errors' => $msg));
    }

    function msg(Request $request)
    {

        $request->session()->reflash();
        return view('front/msg');
    }

    function inviteFreelancer(Request $request)
    {
        $project = project::where('projectOwner_id', session('user')['id'])->where('VIPUser', session('user')['id'])->find($request->id);
        if ($project) {
            $q = $request->q ? $request->q : '';
            $data['freelancers'] = user::where(function ($query) {
                $query->where('type', 2)->orWhere('type', 3)->where('id', '<>', session('user')['id']);
            })->where(function ($query) use ($q) {
                $query->where('fname', 'like', '%' . $q . '%')->orWhere('lname', 'like', '%' . $q . '%')->orWhereHas('specialization', function ($query) use ($q) {
                    $query->where('name', 'like', '%' . $q . '%');
                })->orWhereHas('country', function ($query) use ($q) {
                    $query->where('name', 'like', '%' . $q . '%');
                });
            })
                ->with('specialization')
                ->with('country')
                ->paginate(4);

            $data['q'] = $q;
            if ($request->ajax()) {
                $json['status'] = 1;
                $json['view'] = view('freelancer.item', $data)->render();
                return response()->json($json);
            } else {
                $data['reportReasons'] = reportreason::get();
                return view('freelancer.index', $data);
            }
        } else {
            abort(404);
        }
    }

    function notifcation($id = 0)
    {
        if ($id) {
            $noti = notifcation::where('user_id', session('user')['id'])->find($id);
            if ($noti) {
                notifcation::where('id', $id)->update(['seen' => 1]);
                return redirect(notificationUrl($noti->type, $noti->type_id));
            } else {
                abort(404);
            }
        } else {
            abort(404);
        }
    }

    function editProfile()
    {
        $user_id = session('user')['id'];
        $data['countries'] = country::get();
        $data['user'] = user::profile($user_id);
        if ( $data['user']->country_id)
        $data['country'] = \App\country::find( $data['user']->country_id);
        $data['portfolios'] = portfolio::where('user_id', $user_id)
            ->with('likes')
            ->with('views')
            ->limit(6)->get();
        $data['skills'] = skill::getAll($user_id);
        $data['statistics'] = user::Statistics($user_id);
        $data['hasSkills'] = \App\userSkills::where('user_id', $user_id)->get()->pluck('skill_id')->toArray();
        $data['complete'] = bid::where(['freelancer_id' => $user_id, 'status' => 3])->count();
        $data['projects_complete_count'] = project::where(['projectOwner_id' => $user_id,'status'=>6])->count();
        $data['specializations'] = specialization::with('skills')->get();
        return view('front.editProfile', $data);
    }

//    projects
    function defaultProject(Request $request)
    {
        $data['projects'] = project::openProject($request);
        if ((!$request->ajax())) {
            $data['reportReasons'] = reportreason::get();
            $data['searchType'] = 'search';
            if (session('user')) {
                $data['skills'] = skill::getAll(session('user')['id']);
            } else {
                $data['skills'] = skill::get();
            }
            $data['reportReasons'] = reportreason::get();
            $data['specializations'] = specialization::with('skills')->get();
            $rs = view('project.index', $data);
        } else {
            $json['status'] = 1;
            $json['view'] = view('project.ajaxProjects', $data)->render();
            $rs = response()->json($json);
        }
        return $rs;
    }

    function projects(Request $request)
    {
        $data['projects'] = project::openProject($request);
        if ((!$request->ajax())) {
            $data['reportReasons'] = reportreason::get();
            if ($request->has('type')) {
                $data['searchType'] = null;
            } else {
                $data['searchType'] = 'advanceSearch';
            }

            if (session('user')) {
                $data['skills'] = skill::getAll(session('user')['id']);
            } else {
                $data['skills'] = skill::get();
            }
            $data['reportReasons'] = reportreason::get();
            $data['specializations'] = specialization::with('skills')->get();
            $rs = view('project.index', $data);
        } else {
            $json['status'] = 1;
            $json['view'] = view('project.ajaxProjects', $data)->render();
            $rs = response()->json($json);
        }
        return $rs;
    }

    function project(Request $request, $id)
    {

        global $setting;
        $id = explode('-', $id)[0];
        $editablePrice = EditPrice::where('project_id', $id)->where('user_id', session('user')['id'])->where('show', 1)->first();
        $project = project::where('id', $id)->with('owner')->with('budget')->with('freelancers')->with('freelancers.user')
            ->first();
        if ($project) {

            if ((!$project->isPrivate) || ($project->freelancer_id == session('user')['id']) || ($project->projectOwner_id == session('user')['id'])) {
                $userId = session('user') ? session('user')['id'] : 0;

                if ($userId != $project->projectOwner_id && $userId != $project->VIPUser) {
                    $data['bidTibs'] = tibs::where('type', 1)->get();
                    if (session('user'))
                        $data['userBid'] = bid::where('freelancer_id', $userId)->where('project_id', $id)
                            ->with('user')->with('file')->with('user.freelancerEvaluate')->first();
                    else
                        $data['userBid'] = null;
                    $data['isOwner'] = 0;
                } else {
                    $data['isOwner'] = 1;
                }

                Session::put('projectId', $id);
                $data['projectEnd'] = \App\projectFreelancer::where('project_id', $id)->first();
                $data['skills'] = projectskills::where('project_id', $id)->with('skill')->get();
                $data['reportReasons'] = reportreason::get();

                $setting['title'] = $project->title;
                $setting['description'] = $project->description;
                $data['project'] = $project;
                $data['evaluate'] = evaluate::where('project_id', $id)->first();
                $data['bids'] = bid::where('project_id', $id)->where('freelancer_id', '<>', $userId)
                    ->with('user')->with('user.freelancerEvaluate')->with('file')->orderBy('id', 'desc')->paginate(10);
                if (($project->status > 2) && (((isset($project->freelancer[0]) ? $project->freelancer[0]->freelancer_id : 0) == session('user')['id']) || ((isset($project->freelancer[0]) && $project->projectOwner_id == session('user')['id']) || ($project->VIPUser == session('user')['id'])))) {
                    $data['descussions'] = projectDescussion::where('project_id', $id)
                        ->with('sender')->with('file')
                        ->where(function ($q) use ($data, $userId, $project) {
                            if (!$data['isOwner']) {
                                $q->where('user_id', $userId)->orWhere('user_id', $project->projectOwner_id);
                            }
                        })
                        ->get();
//                    if ((session('user')['id'] == $project->freelancer[0]->freelancer_id) || (session('user')['id'] == $project->owner_id))
                    return view('project.descution', $data);
//                    return view('project.single', $data);
                } else {


//                     exit;
                        $projectbudget = projectBudget::get();
                    return view('project.single', $data)->with('editablePrice', $editablePrice)->with('projectbudget', $projectbudget);
                }
            } else {
                return $this->viewError('هذا المشروع خاص ');
            }
        } else {
            return $this->viewError('الرجاء التأكد من المشروع');
        }
    }

    function projectsSearch(Request $request)
    {
        $budget = explode(';', $request->budget);
        $data['projects'] = project::openProject($request);
        if (!$request->ajax()) {
            $data['searchType'] = 'advanceSearch';
            if (session('user')) {
                $data['skills'] = skill::getAll(session('user')['id']);
            } else {
                $data['skills'] = skill::get();
            }
            $data['reportReasons'] = reportreason::get();
            $data['specializations'] = specialization::with('skills')->get();

            $rs = view('project.index', $data);
        } else {
            $json['status'] = 1;
            $json['view'] = view('project.ajaxProjects', $data)->render();
            $rs = response()->json($json);
        }
        return $rs;
    }

    function testNoti()
    {

    }

    function addProject()
    {
        if (!checkType('addProject')) {
            return redirect('/editProfile');
        }
        $user_id = session('user')['id'];
        $data['statistics'] = $statistics = user::Statistics($user_id);
        $data['specializations'] = specialization::with('skills')->get();
        $data['projectbudget'] = projectBudget::get();
        $data['skills'] = skill::get();
        $data['user'] = user::profile($user_id);
        $data['users'] = user::where('isFinishProfile', 1)->where('isVIP', 0)->get();
        return view('project.add', $data);
    }

//    freelancer
    function freelancers(Request $request)
    {
        $project = project::where('projectOwner_id', session('user')['id'])->orWhere('VIPUser', session('user')['id'])->find($request->id);

        if ($project) {
            $data['project_id'] = $request->id;
        }
        $q = $request->q ? $request->q : '';
        $data['freelancers'] = user::select('user.*', 'favorite.refer_id')
            ->where(function ($query) {
                $query->where('user.type', 1)->orWhere('user.type', 3);
            })->where('user.id', '<>', DB::raw(session('user')['id']))
            ->where(function ($query) use ($q) {
                $query->where('fname', 'like', '%' . $q . '%')->orWhere('lname', 'like', '%' . $q . '%')
                    ->orWhereHas('specialization', function ($query) use ($q) {
                        $query->where('name', 'like', '%' . $q . '%');
                    })->orWhereHas('country', function ($query) use ($q) {
                        $query->where('name', 'like', '%' . $q . '%');
                    });
            })->where('isFinishProfile', 1)
            ->leftJoin('favorite', function ($q) {
                $q->on('favorite.refer_id', '=', 'user.id')->on('favorite.type', '=', DB::raw(3))->on('favorite.user_id', '=', DB::raw(session('user')['id']));
            })
            ->with('specialization')
            ->with('country')
            ->with('freelancerEvaluates')
            ->paginate(16);

        $data['q'] = $q;
        if ($request->ajax()) {
            $json['status'] = 1;
            $json['view'] = view('freelancer.item', $data)->render();
            return response()->json($json);
        } else {
            $data['reportReasons'] = reportreason::get();
            return view('freelancer.index', $data);
        }
    }

    function evaluate($id)
    {
        $project = project::where('status', 6)->find($id);

        if ($project) {
            $evaluate = evaluate::where('evaluating_owner', $project->freelancer[0]->freelancer_id)->where('project_id', $id)->first();
            $data['project'] = $project;
            if ($evaluate) {
                $data['evaluate'] = $evaluate;
                return view('project.viewEvaluate', $data);
            } else {
                return view('project.evaluate', $data);
            }
        } else {
            session()->flash('error', 'خطأ في الصفحة');
        }
        return redirect('/msg');
    }

    function addPrivateProject($id)
    {
        $data['freelancer'] = user::find($id);
        if ($data['freelancer']) {
            $user_id = session('user')['id'];
            if ($user_id == $id) return redirect('projects');
            $data['statistics'] = $statistics = user::Statistics($user_id);
            $data['specializations'] = specialization::with('skills')->get();

            $data['projectbudget'] = projectBudget::get();
            $data['skills'] = skill::get();
            $data['user'] = user::profile($user_id);
            return view('freelancer.add', $data);
        } else
            abort(404);
    }

    function freelancerSearch(Request $request)
    {
        $project = project::where('projectOwner_id', session('user')['id'])->find($request->id);

        if ($project) {
            $data['project_id'] = $request->id;
        }
        $user_id = session('user')['id'];

        $data['skills'] = skill::getAll($user_id);
        $ids = [];
//         foreach ($data['skills'] as $skill) {
//             if ($skill->hasSkill);
// //                 array_push($ids, $skill->id);
//         }
        $specialization_id = $request->specialization_id ? $request->specialization_id : 0;
        $country_id = $request->country_id ? $request->country_id : 0;
        $skills = isset($request->skills) ? $request->skills : ((sizeof($ids) && !$request->ajax()) ? $ids : []);
        $star = $request->star ? 1 : 0;
        $check = isset($request->check) ? 1 : 0;
        $query = user::where('isFinishProfile', 1)->where('id', '<>', $user_id)
            ->where(function ($query) {
                $query->where('type', 1)->orWhere('type', 3);
            });


        if ($specialization_id != 0) {
            $query->where('specialization_id', $specialization_id);
        } else {
            specialization::with('skills')->get();
        }

        if ($country_id != 0) {
            $query->where('country_id', $country_id);
        }
        if (sizeof($skills) && !empty($skills)) {

            $query->whereHas('skills', function ($q) use ($skills) {
                $q->whereIn('skill_id', $skills);
            });
        }
        if ($star != 0) {
            $query->where('stars', $request->star);
        }
        $now = \Carbon\Carbon::now()->toDateTimeString();
        if ($check)
            $query->where(DB::raw('TIMESTAMPDIFF(MINUTE ,lastLogin, "' . $now . '")'), '<', 15);


        $query->with('specialization')
            ->with('country')
            ->with('freelancerEvaluate');
        $data['freelancers'] = $query->paginate(16);

        $data['searchType'] = 'advanceSearch';

        if ($request->ajax()) {
            $json['status'] = 1;
            $json['view'] = view('freelancer.item', $data)->render();
            return response()->json($json);
        } else {
            $data['reportReasons'] = reportreason::get();
            $data['countries'] = country::get();
            $user_id = session('user')['id'];
            $data['statistics'] = user::Statistics($user_id);
            $data['specializations'] = specialization::with('skills')->get();
            return view('freelancer.index', $data);
        }
    }

    function vip()
    {
        $faqs = FAQ::where('isVIP', 1)->limit(10)->get();
        $specializations = specialization::get()->pluck('name', 'id');
        $budget = projectBudget::get();
        return view('front.vip', compact('faqs', 'budget', 'specializations'));
    }

    function singleUser($user_id = 0)
    {
        $user = user::where(function ($q) use ($user_id) {
            $q->whereId($user_id)->orWhere('username', $user_id);
        })->where('isdelete', 0)->first();

        if ($user && ($user_id)) {
            if (!$user->isFinishProfile) {
                session()->flash('error', 'هذا المستخدم غير موجود');
                return redirect('/projects');
            }
            $id = $user->id;
            $user_id = $id;
        } else {
            $id = session('user')['id'];
            $user_id = 0;
        }
        $data['user'] = user::profile($id);
        if (sizeof($data['user'])) {
            $data['statistics'] = $statistics = user::Statistics($id);
            $data['evaluates'] = user::getEvaluate($id);
            $query = portfolio::where('user_id', $id)
                ->with('likes')
                ->with('views');
            if ($user_id)
                $query->where('isBlock', 0);
            $data['portfolios'] = $query->limit(6)->get();

            $data['bids'] = bid::getAll($id);
            $data['projects'] = project::where(function ($q) use ($id) {
                $q->where('projectOwner_id', $id)->orWhere('VIPUser', $id);
            })
                ->with('bids')->with('budget')
                ->latest()->paginate(8);

            $url_pre = URL::previous();


            $tab = 'about';
            if (str_contains($url_pre, 'project') && Session::get('projectId')) {


                $tab = 'bids';
                $pro_id = Session::get('projectId');
                $pro = project::where('id', $pro_id)->first();
                if ($pro && $pro->owner_id == $id)
                    $tab = 'projects';
                Session::put('projectId','');
            }
            $data['tab'] = $tab;
      ;
//            $projects = project::where(function($q){
//                $q->where('projectOwner_id', session('user')['id'])->orWhere('VIPUser', session('user')['id']);
//            })
//                ->with('bids')->with('budget')
//                ->latest()
////                 ->where('status', '<>', 1)
////                 ->where('status', '<>', 4)
//                ->where('title', 'like', '%' . $q . '%')
//                ->paginate(6);

            $data['awaitingConfirmationBids'] = bid::where(['freelancer_id' => $id, 'status' => 1])->count();
            $data['underway'] = bid::where(['freelancer_id' => $id, 'status' => 2])->count();
            $data['complete'] = bid::where(['freelancer_id' => $id, 'status' => 3])->count();
            $data['canceled'] = bid::where(['freelancer_id' => $id, 'status' => 4])->count();
            $data['closed']   = bid::where(['freelancer_id' => $id, 'status' => 5])->count();
            $data['away'] = bid::where(['freelancer_id' => $id, 'status' => 6])->count();
            $data['blocked'] = bid::where(['freelancer_id' => $id, 'status' => 7])->count();

            $data['bids_count'] = bid::where(['freelancer_id' => $id])->count();
            $data['projects_pending_count'] = project::where(['projectOwner_id' => $id,'status'=>1])->count();
            $data['projects_progress_count'] = project::where(['projectOwner_id' => $id,'status'=>3])->count();
            $data['projects_cancel_count'] = project::where(['projectOwner_id' => $id,'status'=>4])->count();
            $data['projects_complete_count'] = project::where(['projectOwner_id' => $id,'status'=>6])->count();
            $data['projects_close_count'] = project::where(['projectOwner_id' => $id,'status'=>5])->count();
            $data['projects_open_count'] = project::where(['projectOwner_id' => $id,'status'=>2])->count();
            $data['projects_blocked_count'] = project::where(['projectOwner_id' => $id,'status'=>7])->count();

            $data['projects_count'] = project::where(['projectOwner_id' => $id])->where('status','<>',7)->count();

            $data['skills'] = skill::getUserSkills($id);
            return view('front.singleUser', $data);
        } else {
            session()->flash('errors', 'خطأ في الرابط');
            return redirect('msg');
        }
    }

    function addPortfolio(Request $request)
    {
        $user_id = session('user')['id'];
        $data['skills'] = skill::all();
        $data['user'] = user::profile($user_id);
        $data['statistics'] = user::Statistics(session('user')['id']);
        return view('portfolio.add', $data);
    }

    function editPortfolio1($id)
    {
        $user_id = session('user')['id'];
        $portfolio = portfolio::where('user_id', $user_id)->where('id', $id)->first();
        if ($portfolio) {
            $data['skills'] = skill::all();
            $data['user'] = user::profile($user_id);
            $data['statistics'] = user::Statistics();
            return view('portfolio.add', $data);
        } else {
            session()->flash('errors', 'لا يمكنك التعديل على هذا العمل');
            return redirect('error');
        }
    }

    function portfolios($id)
    {
        $data['user'] = user::profile($id);
        setting::siteSettings(['']);
        if (sizeof($data['user'])) {
            $data['statistics'] = $statistics = user::Statistics($id);
            $data['portfolios'] = portfolio::withFeedback(0, $id);
            $data['user_id'] = $id;
            $data['projects_complete_count'] = project::where(['projectOwner_id' => $id,'status'=>6])->count();
            $data['complete'] = bid::where(['freelancer_id' => $id, 'status' => 3])->count();

            return view('portfolio.index', $data);
        } else {
            session()->flash('errors', 'خطأ في الرابط');
            return redirect('error');
        }
    }

    function myPortfolios()
    {
        $id = session('user')['id'];
        $data['user'] = user::profile($id);
        if (sizeof($data['user'])) {
        $data['complete'] = bid::where(['freelancer_id' => $id, 'status' => 3])->count();
            $data['projects_complete_count'] = project::where(['projectOwner_id' => $id,'status'=>6])->count();
            $data['statistics'] = $statistics = user::Statistics($id);
            $data['portfolios'] = portfolio::withFeedback(0, $id);
            $data['user_id'] = $id;
            return view('portfolio.index', $data);
        } else {
            session()->flash('errors', 'خطأ في الرابط');
            return redirect('error');
        }
    }

    function portfolio($id)
    {
        global $setting;
        $portfolio = portfolio::withFeedback($id);
        if ($portfolio) {
            if ($portfolio->user_id != session('user')['id'] && $portfolio->isBlock) {
                session()->flash('errors', 'هذا العمل محظور');
                return redirect('error');
            }
            $user_id = session('user')['id'];
            \App\view::checkAndAdd($user_id, $id, 1);
            $data['portfolio'] = $portfolio;

            $data['skills'] = skill::getPortfolioSkills($portfolio->skills);
            $data['images'] = [];
            if (json_decode($portfolio->files))
                $data['images'] = \App\file::whereIn('id', json_decode($portfolio->files))->get();

            $data['reportReasons'] = reportreason::get();
            $setting['title'] = $data['portfolio']->title;
            $setting['description'] = $data['portfolio']->description;
            $setting['image'] = $data['portfolio']->Thumbnail;
            return view('portfolio.view', $data);
        } else {
            session()->flash('errors', 'خطأ في الرابط');
            return redirect('error');
        }
    }

    function editPortfolio($id)
    {
        $user_id = session('user')['id'];
        $portfolio = portfolio::where('user_id', $user_id)->where('id', $id)->first();

        if ($portfolio) {
            $data['portfolio'] = $portfolio;
            $data['skills'] = skill::all();
            $data['user'] = user::profile($user_id);
            $data['statistics'] = user::Statistics($user_id);
            $data['images'] = [];
            if (json_decode($portfolio->files))
                $data['images'] = \App\file::whereIn('id', json_decode($portfolio->files))->get();
            return view('portfolio.edit', $data);
        } else {
            session()->flash('errors', 'لا يمكنك تحرير هذا العمل');

            return redirect('error');
        }
    }

    function deletePortfolio($id)
    {
        $user_id = session('user')['id'];
        $portfolio = portfolio::where('user_id', $user_id)->where('id', $id)->first();
        file::where('refer_id', $portfolio->id)->where('referal_type', 3)->delete();
        $portfolio->delete();
        return redirect('/portfolios');
    }

    function notifcationSetting()
    {
        $user_id = session('user')['id'];
        $data['user'] = user::profile($user_id);
        $data['notiPerms'] = \App\notifcationPerm::where('user_id', $user_id)->get()->pluck('user_id', 'type');
        $data['portfolios'] = portfolio::where('user_id', $user_id)
            ->with('likes')
            ->with('views')
            ->limit(6)->get();
        return view('my.notifcationSetting', $data);
    }

    function conversationById($id)
    {
        $con = conversation::with('messages.sender')
            ->with('messages.files')
            ->where(function ($q) {
                $q->where('sender_id', session('user')['id'])
                    ->orWhere('reciever_id', session('user')['id'])
                    ->orWhere('VIPUser', session('user')['id']);
            })
            ->where('id', $id)
            ->first();
        if ($con) {
            global $templateData;
            message::where('conversation_id', $con->id)->where('reciever_id', session('user')['id'])->update(['seen' => 1]);

            $templateData['messages'] = \App\conversation::whereHas('messages', function ($q) {
                $q->where('reciever_id', session('user')['id'])
                    ->orWhere('ViPUser', session('user')['id']);
            })->latest()->limit(10)->get();

            $unseen = 0;
            foreach ($templateData['messages'] as $value) {
                if (session('user')['isVIP']) {
                    if ($value->messages->last()->VIPSeen === 0)
                        $unseen++;
                } else {
                    if (!$value->messages->last()->seen && $value->messages->last()->reciever_id == session('user')['id'])
                        $unseen++;
                }
            }
            $templateData['unseen'] = $unseen;


            $data['con'] = $con;
            $data['conversation'] = $con;
            $data['tibs'] = tibs::where('type', 2)->get();
            $data['conSta'] = conversation::statistic(session('user')['id']);
            $data['unseen'] = conversation::unssen(session('user')['id']);
            return view('message.conversation', $data);
        } else {
            abort(404);
        }
    }

    function conversations(Request $request)
    {
        $user_id = session('user')['id'];
        $q = (isset($request['q'])) ? $request['q'] : '';
        $fillterO = ['all', 'sent', 'recieve'];
        $in = array_search($request['fillter'], $fillterO);
        $fillter = ($in !== false) ? $fillterO[$in] : 'all';


        $query = conversation::with('sender')
            ->with('lastMessage')
            ->with('reciever')
            ->with('project')
            ->latest()
            ->where(function ($q) use ($user_id, $fillter) {
                if ($fillter == 'recieve') {
                    $q->where('reciever_id', $user_id);
                } else if ($fillter == 'sent') {
                    $q->where('sender_id', $user_id);
                } else {
                    $q->where('sender_id', $user_id)->orWhere('VIPUser', session('user')['id'])
                        ->orWhere('reciever_id', $user_id);
                }
            });
        if ($q) {
            $query->whereHas('messages', function ($query) use ($q) {
                $query->where('content', 'like', '%' . $q . '%');
            });
        }
        $data['cons'] = $query->paginate(10);
        $data['cons']->withPath(url()->full());
        if ($request->ajax()) {
            $json['view'] = view('message.messageItem', $data)->render();
            $json['status'] = 1;
            return response()->json($json);
        } else {
            $data['type'] = '1';
            $data['conSta'] = conversation::statistic($user_id);
            $data['unseen'] = conversation::unssen($user_id);
            $data['fillter'] = $fillter;
            return view('message.conversations', $data);
        }
    }

    function conversation(Request $request)
    {
        $project = project::where('id', $request['project_id'])->where('projectOwner_id', session('user')['id'])
            ->orWhere('VIPUser', session('user')['id'])
            ->first();
        if ($project) {
            $bid = bid::where('freelancer_id', $request['user_id'])->where('project_id', $request['project_id'])->first();
            if ($bid) {
                $con = conversation::orderBy('id')->where('project_id', $request['project_id'])
                    ->with('messages.sender')
                    ->with('messages.files')
                    ->where('reciever_id', $request['user_id'])
                    ->first();
                if (!$con) {

                    $con = new conversation();
                    $con->sender_id = $project->projectOwner_id;
                    $con->reciever_id = $request['user_id'];
                    $con->project_id = $request['project_id'];
                    if ($project->isVIP)
                        $con->VIPUser = $project->VIPUser;
                    $con->save();
                    $editable = new EditPrice();
                    $editable->user_id = $project->projectOwner_id;
                    $editable->reciever_id = $request['user_id'];
                    $editable->project_id = $request['project_id'];
                    $editable->save();
                    Session::put('editable', $request['user_id']. '-' . $request['project_id']);
                    
                } else {
                    global $templateData;

                    message::where('conversation_id', $con->id)->where('reciever_id', session('user')['id'])->update(['seen' => 1]);

                    $templateData['messages'] = \App\conversation::whereHas('messages', function ($q) {
                        $q->where('reciever_id', session('user')['id'])
                            ->orWhere('VIPUser', session('user')['id']);
                    })->latest()->limit(10)->get();

                    $unseen = 0;
                    foreach ($templateData['messages'] as $value) {
                        if (session('user')['isVIP']) {
                            if ($value->messages->last()->VIPSeen === 0)
                                $unseen++;
                        } else {
                            if (!$value->messages->last()->seen && $value->messages->last()->reciever_id == session('user')['id'])
                                $unseen++;
                        }
                    }
                    $templateData['unseen'] = $unseen;

                }
                $data['con'] = $con;
                $data['conversation'] = $con;
                $data['tibs'] = tibs::where('type', 2)->get();
                $data['conSta'] = conversation::statistic(session('user')['id']);
                $data['unseen'] = conversation::unssen(session('user')['id']);
                return view('message.conversation', $data);
            } else {
                return $this->viewError('الرابط الذي تحاول الوصول اليه خاطئ');
            }
        } else {
            return $this->viewError('الرابط الذي تحاول الوصول اليه خاطئ');
        }
    }

//    not ready

    function statistic(Request $request)
    {
        $user_id = session('user')['id'];
        $data['user'] = user::profile1($user_id);
//            $data['statistics'] = user::Statistics($user_id);
//            $data['user']=user::where('id',$user_id)->with('specialization')->with('country')->first();
        $data['portfolios'] = portfolio::where('user_id', $user_id)
            ->with('likes')
            ->with('views')
            ->limit(6)->get();
        return view('my.statistic', $data);
    }

    function myFavorite(Request $request)
    {
        $q = ($request->q) ? $request->q : '';

        if ($request->type == 'freelancer') {
            $type = 3;
            $data['type'] = 'freelancer';
            $data['include'] = 'my.favoriteFreelancer';
        } else if ($request->type == 'portfolio') {
            $type = 1;
            $data['type'] = 'portfolio';
            $data['url'] = 'portfolio';
            $data['include'] = 'my.favoritePortolio';
        } else {
            $type = 2;
            $data['type'] = 'project';
            $data['url'] = 'project';
            $data['include'] = 'my.favoriteProject';
        }
        $query = favorite::where('type', $type);
        if ($type == 2) {
            $query->whereHas('project', function ($query) use ($q) {
                $query->where('title', 'like', '%' . $q . '%');
            });
        }
        $query->where('user_id', '=', session('user')['id']);
        if ($type == 3)
            $query->whereHas('user', function ($query) use ($q) {
                $query->where('fname', 'like', '%' . $q . '%');
                $query->orWhere('lname', 'like', '%' . $q . '%');
            })->with('user')->with('user.portfolio');

        if ($type == 1) {
            $query->whereHas('portfolio', function ($query) use ($q) {
                $query->where('title', 'like', '%' . $q . '%');
            });
        } else if ($type == 1)
            $query->with('portfolio')->with('portfolio.likes')->with('portfolio.views');
        else
            $query->with('bids')->with('project')->with('project.bids')->with('project.budget');

        $data['favorites'] = $query->latest()->paginate(15);

        $data['favorites']->setPath('myFavorite?type=' . $data['type']);
        $data['url'] = '/myFavorite';
        $data['type1'] = $data['type'];
        $data['type'] = $type;
        $data['q'] = $q;
        if ($request->ajax()) {
            $json['status'] = 1;
            $json['view'] = view('my.item', $data)->render();
            return response()->json($json);
        } else
            return view('my.favorite', $data);
    }

    function balance(Request $request)
    {
        $user_id = session('user')['id'];
        $data['user'] = user::profile($user_id);
        $data['portfolios'] = portfolio::where('user_id', $user_id)
            ->with('likes')
            ->with('views')
            ->limit(6)->get();
        $data['transactions'] = transaction::where('sender_id', session('user')['id'])->latest()->orWhere('reciever_id', session('user')['id'])->paginate(10);
        $data['statistics'] = user::Statistics($user_id);
        $data['awaitingConfirmationBids'] = bid::where(['freelancer_id' => $user_id, 'status' => 1])->count();
        $data['underway'] = bid::where(['freelancer_id' => $user_id, 'status' => 2])->count();
        $data['complete'] = bid::where(['freelancer_id' => $user_id, 'status' => 3])->count();
        $data['canceled'] = bid::where(['freelancer_id' => $user_id, 'status' => 4])->count();
        $data['all'] = bid::where(['freelancer_id' => $user_id])->count();

        if ($request->ajax()) {
            $view = view('my.transaction_item', $data)->render();
            return response()->json(['view' => $view]);
        }
        return view('my.balance', $data);
    }

    function myProjects(Request $request)
    {
        $q = (isset($request['q'])) ? $request['q'] : '';
        $projects = project::where(function ($q) {
            $q->where('projectOwner_id', session('user')['id'])->orWhere('VIPUser', session('user')['id']);
        })
            ->with('bids')->with('budget')
            ->latest()
//                 ->where('status', '<>', 1)
//                 ->where('status', '<>', 4)
            ->where('title', 'like', '%' . $q . '%')
            ->paginate(6);

        if ($request->ajax()) {
            $json['status'] = 1;
            $data['projects'] = $projects;

            $json['all'] = 1;
            $json['view'] = view('my.ajaxProject', $data)->render();
            return response()->json($json);
        }

        $data['url'] = '/myProjects';
        $data['q'] = $q;

        $data['all'] = 1;
        $data['projects'] = $projects;
        return view('my.projects', $data);
    }

    function fillterMyProjects($id, Request $request)
    {
        $q = (isset($request['q'])) ? $request['q'] : '';
        $projects = project::fillter($id, $q)->paginate(6);
        $data['projects'] = $projects;
        $data['fillter'] = $id;
        $data['url'] = '/myProjects/' . $id;
        $data['q'] = $q;
        if ($request->ajax()) {
            $json['status'] = 1;
            $data['projects'] = $projects;

            $json['view'] = view('my.ajaxProject', $data)->render();
            return response()->json($json);
        }
        return view('my.projects', $data);
    }

    function myBids(Request $request, $status = 0)
    {
        $q = $request->q ? $request->q : '';
        $type = $status;

        $open_project_day = \App\setting::where('set_id', 'open_project_day')->first(['set_data'])->set_data;
        global $setting;
        $now = \Carbon\Carbon::now()->subDays($setting['open_project_day']);
        $query = bid::where('freelancer_id', session('user')['id']);
        if ($request->has('q')) {
            $query->whereHas('project', function ($query) use ($q) {
                $query->where('title', 'like', '%' . $q . '%');
            });
        }
        $data['statusType'] = $this->getType($status);

         if ($status != 0) {
            $data['bids'] = $query->with('project')->with('project.bids')->where('status', $status)->orderBy('created_at', 'DESC')->paginate(8);
        } else {
            $data['bids'] = $query->with('project')->with('project.bids')->orderBy('created_at', 'DESC')->paginate(8);
        }

        $data['type'] = $type;
        $data['q'] = $q;
        if ($request->ajax()) {
            $json['status'] = 1;
            $json['view'] = view('my.bidContent', $data)->render();
            return response()->json($json);
        } else
            return view('my.bids', $data);
    }


    function messages(Request $request)
    {
        return view('message.index');
    }

//    ajax


    function getBidsProject(Request $request)
    {
        $data['project'] = project::where('id', $request['id'])
            ->first();
        $data['bids'] = bid::where('project_id', $request['id'])->where('freelancer_id', '<>', session('user')['id'])->orderBy('id', $request['bidsOrder'])->with('user')->with('user.freelancerEvaluate')->paginate(10);
        $data['bidsOrder'] = $request['bidsOrder'];
        if ($request->ajax()) {
            $data['reportReasons'] = reportreason::get();
            $project = project::where('id', $request['id'])->first();
            \Carbon\Carbon::setLocale('ar');
            if (session('user')['id'] == $project->projectOwner_id) {
                return Response::json(['view' => view('project.bidOwner', $data)->render()]);
            } else {
                return Response::json(['view' => view('project.bids', $data)->render()]);
            }
        }
    }

    function getBids(Request $request)
    {
        global $setting;
        $data['setting'] = $setting;
        if ($request->type == 'project') {
            $project = new project();
            $data['projects'] = $project->getAll($request['id'], $request['fillterTime'], $request['fillterType']);
            if ($request->ajax()) {
                return Response::json(['view' => view('front.singleUserProjects', $data)->render()]);
            }
        } else {

            $data['bids'] = bid::getAll($request['id'], $request['fillterTime'], $request['fillterType']);
            $data['type'] = $this->getType($request['fillterType']);
            if ($request->ajax()) {
                return Response::json(['view' => view('front.bids', $data)->render()]);
            }

        }

    }

    function getType($type)
    {
        switch ($type) {
            case 0:
                return 'الكل';
                break;
            case 1:
                return 'بإنتظار الموافقة';
                break;
            case 2:
                return 'قيد التنفيذ';
                break;
            case 3:
                return 'مكتمل';
                break;
            case 4:
                return 'ملغي';
                break;
            case 5:
                return 'مغلق';
                break;
            case 6:
                return 'مستبعد';
                break;
            case 7:
                return 'محظور';
                break;
        }
    }

    function getPortfolio(Request $request)
    {
        $data['portfolios'] = portfolio::where('user_id', $request['id'])->paginate(20);
        if ($request->ajax()) {

            $data['user_id'] = $request['id'];
            return Response::json(['view' => view('portfolio.portofolios', $data)->render()]);
        }
    }

    function getEvaluate(Request $request)
    {
        $data['evaluates'] = user::getEvaluate($request['id'], $request['evaluteOrder']);
        if ($request->ajax()) {
            return Response::json(['view' => view('front.evaluates', $data)->render()]);
        }
    }

    function editBid($id)
    {
        $bid = bid::where('id', $id)->where('freelancer_id', session('user')['id'])->first();
        if ($bid) {
            $json['status'] = 1;
            $data['bidEdit'] = $bid;
            $data['bidTibs'] = tibs::where('type', 1)->get();

            $json['view'] = view('project.addBid', $data)->render();
        } else {
            $json['status'] = 0;
            $json['msg'] = 'حصل خطأ ما!';
        }
        return Response::json($json);
    }

    public function editablePrice(Request $request, $id)
    {
        $freelancerId = substr(Session::get('editable'), 0, strpos(Session::get('editable'), '-'));
        $freelancer = \App\User::find($freelancerId);
        $project = project::find($id);
        $project->budget_id = $request->editable;
        $project->save();
        $editable = EditPrice::where('project_id', $id)->where('user_id',session('user')['id'])->where('reciever_id', $freelancerId . '-' .$id)->first();
        $editable->show = 0;
        $editable->updated = 1;
        $editable->save();

        notifcation::addNew(12, $project->id, $project->projectOwner_id, 'تعديل الميزانية', 'تم تعديل الميزانية:  ' . $project->title , 0);
        notifcation::addNew(12, $project->id, $freelancerId, 'تعديل الميزانية', 'تم تعديل الميزانية:  ' . $project->title , 0);


        \Illuminate\Support\Facades\Mail::to($freelancer->email)
                    ->send(new \App\Mail\SendMessage('تم تعديل الميزانية', 'انجزلى', $project->title, 'انجزلى'));
       
        return redirect()->back();
    }

}
