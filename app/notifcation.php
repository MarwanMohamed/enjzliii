<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
class notifcation extends Model
{

    //
    protected $table = 'notifcation';
    protected $fillable = ['seen_api'];

    function owner()
    {
        return $this->belongsTo('App\user', 'owner_id');
    }

    function project(){
        return $this->belongsTo('App\project','project_id');
    }
    function fullname()
    {
        if ($this->owner) {
            return $this->owner->fname . ' ' . $this->owner->lname;
        } else {
            return 'رسالة ادارية';
        }
    }

//    function avatar() {
//        global $setting;
//        if ($this->owner) {
//            if ($this->owner->avatar && !str_contains($this->owner->avatar, 'image_'))
//                return $this->owner->avatar;
//            return ($this->owner->avatar) ? '/image_r/200/' . $this->owner->avatar : $setting['default_avatar'];
//        }else {
//            return $setting['default_avatar'];
//        }
//    }
    function avatar()
    {
        global $setting;
        $male = \App\setting::where('set_id', 'MALE_AVATAR')->first(['set_data'])->set_data;
        $female = \App\setting::where('set_id', 'FEMALE_AVATAR')->first(['set_data'])->set_data;
        $imageType = ($this->owner && $this->owner->gender == 1) ? asset('images/users/' . $male) : asset('images/users/' . $female);
        if ($this->owner_id == 0) {
            return url('/image/50x50/image_admin.png');
        }
        if($this->owner && str_contains($this->owner->avatar,'http')){
            return $this->owner->avatar;
        }
            return ($this->owner && $this->owner->avatar) ? '/image_r/200/' . $this->owner->avatar : $imageType;

    }

    static function addNew($type, $type_id, $user_id, $title, $details, $owner_id = 0, $VIPUser = 0,$project_id=0)
    {

        global $setting;

        $notiPerm = \App\notifcationPerm::where('user_id', $user_id)->get()->pluck('user_id', 'type');


        $addNoti = true;

        if ($type == 3 || $type == 6) {
//            check if type addBid or editBid
            if (!isset($notiPerm['2' . $type])) {
                $addNoti = false;
            }
        }

        if ($addNoti) {
            $not1 = new notifcation();
            $not1->type = $type;
            $not1->owner_id = $owner_id;
            $not1->user_id = $user_id;
            $not1->type_id = $type_id;
            $not1->title = $title;
            $not1->details = $details;
            $not1->project_id=$project_id;
            $not1->save();


            $user = user::where('id', $user_id)->first();
            if ($user) {
                if (isset($notiPerm[$type])) {
                    if ($user->email)
                        \Illuminate\Support\Facades\Mail::to($user->email)
                            ->send(new \App\Mail\contact($setting['cu_email'], 'تنبيه جديد', $title, $details, url('/notifcation/' . $not1->id)));
                }
            }
        }
        if ($type == 3 || $type == 5 || $type == 7) {
            //vip User
            if (session('user')['id'] != $VIPUser) {
                $project = project::find($type_id);

                if ($project && $project->isVIP) {
                    $not = new notifcation();

                    $not->type = $type;
                    $not->owner_id = $owner_id;
                    $not->user_id = $project->VIPUser;
                    $not->type_id = $type_id;
                    $not->title = $title;
                    $not->details = $details;
                    $not->project_id=$project_id;
                    $not->save();
                }
            }
        }

    }


}
