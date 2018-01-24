<?php

namespace App;

use App\Services\Encrypt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class user extends Model {

    protected $table = 'user';
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['isVIP',
        'name','gender', 'email','new_email','device_token', 'password', 'fname', 'lname', 'social', 'avatar', 'finishProfileStep', 'specialization_id'
    ];

    function reports() {
        return $this->hasMany('App\report', 'refer_id')->where('type', 3);
    }

    function bids() {
        return $this->hasMany('App\bid', 'freelancer_id', 'id');
    }


    function myProjects() {
        return $this->hasMany('App\project', 'projectOwner_id', 'id');
    }

    function socialProvider() {
        return $this->hasMany('App\social', 'user_id', 'id');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','mobile_country_id','emailConfirm','mobileConfirm',
        'updated_at','salt','blockReason','isSocial'
        ,'deleted_at','isdelete','api_token'
    ];

    function fullname() {
        $first = explode(' ', $this->fname);
        $last = explode(' ', $this->lname);
        return $first[0] . ' ' . $last[0];
    }

    function transactionSent() {
        return $this->hasMany('App\transaction', 'sender_id');
    }

    function transactionRecieved() {
        return $this->hasMany('App\transaction', 'reciever_id');
    }

    function avatar() {
        global $setting;
        if ($this->id) {
            if ($this->avatar && !str_contains($this->avatar, 'image_')) {
                if (str_contains($this->avatar, '?')) {
//                     $avatar = preg_replace('/width=\d*/i', 'width=200', $this->avatar);
                    return $this->avatar;
                } else {
                    return $this->avatar;
                }
            }
            $male = \App\setting::where('set_id', 'MALE_AVATAR')->first(['set_data'])->set_data;
            $female = \App\setting::where('set_id', 'FEMALE_AVATAR')->first(['set_data'])->set_data;
            $imageType = ($this->gender == 1)?asset('images/users/'.$male):asset('images/users/'.$female);

            return ($this->avatar) ? (file_exists('/image_r/200/' . $this->avatar)?'/image_r/200/' . $this->avatar:$imageType) : $imageType;

        } else {
            return ($this->avatar) ? (file_exists('/image_r/200/' . $this->avatar)?'/image_r/200/' . $this->avatar:$setting['default_avatar']) : $setting['default_avatar'];
        }
    }

    function specialization() {
        return $this->belongsTo('App\specialization');
    }

    function country() {
        return $this->belongsTo('App\country');
    }

    static function getSecondData($id) {
        $rs = user::select(['*', DB::raw('select * from user')])
                ->where('user.id', $id)
                ->leftJoin('userskills as us', 'us.user_id', '=', 'user.id')
                ->leftJoin('skill s', 's.id', '=', 'us.skill_id')
                ->get();
    }

    function skills() {
        return $this->hasMany('App\userSkills', 'user_id', 'id');
    }

    function portfolio() {
        return $this->hasMany('App\portfolio')->limit(6);
    }

    function portfolios() {
        return $this->hasMany('App\portfolio');
    }

    function finishProject() {
        return $this->hasManyThrough('App\project', 'App\projectFreelancer', 'freelancer_id', 'projectOwner_id', 'id')->select('projectfreelancer.id as free');
    }

    function freelancerEvaluate() {
        return $this->hasMany('App\evaluate', 'freelancer_id', 'id')->with('user');
    }

//    function freelancerEvaluates() {
//        return $this->hasMany('App\evaluate', 'evaluating_owner', 'id')->with('user');
//    } 
    function freelancerEvaluates() {
        return $this->hasMany('App\evaluate', 'evaluating_owner', 'id');
    }

    static function myBalance($id = 0) {
        $id = $id ? $id : session('user')['id'];
        return user::where('id', $id)->select('balance')->first()->balance;
    }

    static function Statistics($user_id) {
        return DB::table('user as u')->select(['u.*',
                            DB::raw('count( distinct pr.id) as finishProjectCount')
                            , DB::raw('count(distinct prprogress.id) as progressProjectCount')
                            , DB::raw('count(distinct allProjects.id) as allProjectCount')
                            , DB::raw('count(distinct deliverProject.id) as deliverProjectCount')
                            , DB::raw('count(distinct pfcancel.id) as cancelProjectCount')
                        ])
                        ->leftJoin('projectfreelancer as pf', function ($q) {
                            $q->on('pf.freelancer_id', '=', 'u.id')->on('pf.status', '=', DB::raw(3));
                        })
                        ->leftJoin('projects as pr', function ($q) {
                            $q->on('pr.id', '=', 'pf.project_id')->on('pr.status', '=', DB::raw(6));
                        })
                        ->leftJoin('projectfreelancer as pfcancel', function ($q) {
                            $q->on('pfcancel.freelancer_id', '=', 'u.id')->on('pfcancel.status', '=', DB::raw(2));
                        })
                        ->leftJoin('projectfreelancer as pfProgress', function ($q) {
                            $q->on('pfProgress.freelancer_id', '=', 'u.id')->on('pfProgress.status', '=', DB::raw(1));
                        })
                        ->leftJoin('projects as prprogress', function ($q) {
                            $q->on('prprogress.projectOwner_id', '=', 'u.id')->on('prprogress.status', '=', DB::raw(3));
                        })
                        ->leftJoin('projects as deliverProject', function ($q) {
                            $q->on('deliverProject.projectOwner_id', '=', 'u.id')->on('deliverProject.status', '=', DB::raw(6));
                        })
                        ->leftJoin('projectfreelancer as allProjects', function ($q) {
                            $q->on('allProjects.freelancer_id', '=', 'u.id');
                        })
                        ->where('u.id', $user_id)
                        ->first();
    }

    static function profile($id = 0) {
        $user = DB::table('user as us')
                        ->select('us.*', 'sp.name as specialization_name', 'c.name as country_name', DB::raw('TRUNCATE(sum(e.quality) /count(e.quality),0) as  quality'), DB::raw('TRUNCATE(sum(e.ProfessionalAtWork) /count(e.ProfessionalAtWork),0) as  ProfessionalAtWork'), DB::raw('TRUNCATE(sum(e.CommunicationAndMonitoring) /count(e.CommunicationAndMonitoring),0) as  CommunicationAndMonitoring'), DB::raw('TRUNCATE(sum(e.experience) /count(e.experience),0) as  experience'), DB::raw('TRUNCATE(sum(e.workAgain) /count(e.workAgain),0) as  workAgain'))
                        ->where('us.id', $id)
                        ->leftJoin('evaluate as  e', 'evaluating_owner', '=', 'us.id')
                        ->leftJoin('specialization as sp', 'sp.id', '=', 'us.specialization_id')
                        ->leftJoin('country as c', 'c.id', '=', 'us.country_id')
                        ->groupBy('us.id')
                        ->first();
        return $user;
    }

    static function profile1($id = 0) {
        $user = DB::table('user as us')->select('us.*', 'sp.name as specialization_name', 'c.name as country_name'
                                , DB::raw('count(distinct allBids.id) as allbidCount,count( distinct newBid.id) as newBidCount,' .
                                        'count( distinct progressBid.id) as progressBidCount,count( distinct completeP.id) as completePCount,count( distinct cancelP.id) as cancelPCount,count(distinct allP.id) as allPCount'))
                        ->where('us.id', $id)
                        ->leftJoin('specialization as sp', 'sp.id', '=', 'us.specialization_id')
                        ->leftJoin('country as c', 'c.id', '=', 'us.country_id')
                        ->leftJoin('bid as allBids', 'allBids.freelancer_id', '=', 'us.id')
                        ->leftJoin('bid as newBid', function ($q) {
                            $q->on('newBid.freelancer_id', '=', 'us.id')->on('newBid.status', '=', DB::raw(1));
                        })->leftJoin('bid as progressBid', function ($q) {
                            $q->on('progressBid.freelancer_id', '=', 'us.id')->on('newBid.status', '=', DB::raw(2));
                        })->leftJoin('projectfreelancer as completeP', function ($q) {
                            $q->on('completeP.freelancer_id', '=', 'us.id')->on('completeP.status', '=', DB::raw(3));
                        })->leftJoin('projectfreelancer as cancelP', function ($q) {
                            $q->on('cancelP.freelancer_id', '=', 'us.id')->on('cancelP.status', '=', DB::raw(2));
                        })->leftJoin('projectfreelancer as allP', function ($q) {
                            $q->on('allP.freelancer_id', '=', 'us.id');
                        })
                        ->groupBy('us.id')->first();
        return $user;
    }

    function checkPass($inputPassword) {
        $encript = new Encrypt();
        $password = $this->password;
        $salt = $this->salt;
        if ($encript->encryptUserPwd($inputPassword, $salt) === $password) {
            return 1;
        } else
            return 0;
    }

    function updatePassword($password) {
        $encript = new Encrypt();
        $salt = $encript->genRndSalt();
        $encPassword = $encript->encryptUserPwd($password, $salt);
        $this->salt = $salt;
        $this->password = $encPassword;
        $this->emailConfirm = 1;
        if ($this->save())
            return true;
        else
            return false;
    }

    static function getEvaluate($id, $evaluteOrder = 0) {
        $orderBy = (!$evaluteOrder) ? 'asc' : 'desc';
        $evaluates = user::select(['e.*', 'evaluating.avatar as avatar', 'min', 'evaluating.fname', 'evaluating.lname', 'evaluating.id as evaluating_id', 'max', 'c.name as country_name', 'sp.name as specialization', 'pr.id as project_id', 'pr.title as project_title', 'deliveryDuration'])
                ->where('user.id', $id)
                ->join('evaluate as e', 'e.evaluating_owner', '=', 'user.id')
                ->leftJoin('projects as pr', 'pr.id', '=', 'e.project_id')
                ->leftJoin('projectbudget as pb', 'pb.id', '=', 'pr.budget_id')
                ->leftJoin('user as evaluating', 'evaluating.id', '=', 'e.evaluated_id')
                ->leftJoin('country as c', 'c.id', '=', 'evaluating.country_id')
                ->leftJoin('specialization as sp', 'sp.id', '=', 'evaluating.specialization_id')
                ->orderBy('e.id', $orderBy)
                ->paginate(5);

        return $evaluates;
    }

    function addDefaultNoti() {
        $idsNoti = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 23, 26];
        $params = [];
        foreach ($idsNoti as $value) {
            $param['user_id'] = $this->id;
            $param['type'] = $value;
            $params[] = $param;
        }
        notifcationPerm::insert($params);
    }

    function getID() {
        return ($this->username ? $this->username : $this->id);
    }

}
