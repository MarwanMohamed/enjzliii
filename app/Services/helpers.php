<?php

global $setting;

function reqToArray($array, $req)
{

    foreach ($array as $value) {
        $ret[$value] = $req[$value];
    }
    return $ret;
}


function get_payment_lin1k($first_name, $last_name, $email, $package_title, $unit_price, $currency = 'SAR', array $additional_data = [])
{

    $fields = array_merge([
        //unused default values but must be sent through gateway
        'cc_phone_number' => '973',
        'phone_number' => '555555555',
        'billing_address' => "default",
        'city' => "manama",
        'state' => "Capital",
        'postal_code' => "97300",
        'country' => "BHR",
        'address_shipping' => "manama",
        'city_shipping' => "manama",
        'state_shipping' => "Capital",
        'postal_code_shipping' => "97300",
        'country_shipping' => "BHR",
        "cms_with_version" => "API USING PHP",
        //used default value but sometimes modified
        'discount' => "0",
        "msg_lang" => 'ar',
        "reference_no" => strtoupper(str_random(3)) . rand(100000000, 999999999),
        'quantity' => "1",
        'other_charges' => "0", //Additional charges. e.g.: shipping charges, taxes, VAT, etc.
    ], $additional_data);

    $fields['cc_first_name'] = ucfirst($first_name);
    $fields['cc_last_name'] = ucfirst($last_name);
    $fields['title'] = implode(' ', [ucfirst($fields['cc_first_name']), ucfirst($fields['cc_last_name'])]);
    $fields['email'] = $email;
    $fields['products_per_title'] = $package_title;
    $fields['currency'] = $currency;
    $fields['unit_price'] = $unit_price;
    $fields['amount'] = $unit_price * $fields['quantity'] + $fields['other_charges'];

    $fields['ip_customer'] = GetIP();
    $fields['ip_merchant'] = $_SERVER['SERVER_ADDR'];

    $fields['return_url'] = url('/api/payment/result');

    return send_paytabs_request($fields);
}


function GetIP()
{
    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
        if (array_key_exists($key, $_SERVER) === true) {
            foreach (array_map('trim', explode(',', $_SERVER[$key])) as $ip) {
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                    return $ip;
                }
            }
        }
    }
}


function requestVisa($amount)
{
    $url = "https://test.oppwa.com/v1/checkouts";
    $data = "authentication.userId=8a8294185cf90dcc015d02d1739a097b" .
        "&authentication.password=B6GaTBwQmZ" .
        "&authentication.entityId=8a8294185cf90dcc015d02d1c704097f" .
        "&amount=" . $amount .
        "&currency=USD" .
        "&paymentBrand=SADAD" .
        "&customParameters[SADAD_OLP_ID]=user415097" .
        "&bankAccount.country=SA" .
        "&customer.ip=123.123.123.123" .
        "&testMode=EXTERNAL" .
        "&shopperResultUrl=http://enjzli.testarapeak.com/singleUser" .
        "&paymentType=DB";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $responseData = curl_exec($ch);
    if (curl_errno($ch)) {
        return curl_error($ch);
    }

    curl_close($ch);
    $response = json_decode($responseData);
//      $checkoutId=$response->id;
    dd($responseData);
    return view('my/visa', compact('checkoutId'));
}

define('GOOGLE_API_KEY', 'AIzaSyC29di_ttUwKIeZ5vHcEEZeFz-KXY7XyQ0');

//    define('GOOGLE_API_KEY', 'AAAA3k1o8l0:APA91bEM1-B4e8feTmL8soRm_X2zuRMnO2Kv5TWFyPeOwUe3V-mp8oe3y-8NJ7JFyWX2wsL8gHh7e4Dbya-0cIJQrI1BAS_xSFGNx3hA4ZlHuMxVVbRmrl8eBKfHNBqqRqgK06TUY3Oh');


function sendPushNotification($registration_ids, $message = 'dd', $post_id = 'dd')
{
    // Set POST variables
//    $url = 'https://fcm.googleapis.com/fcm/send';
    $url = 'https://fcm.googleapis.com/fcm/send';

    $msg = array
    (
        'body' => 'نص تجريبي نص تجريبي نص تجريبي نص تجريبي نص تجريبي نص تجريبي',
        'title' => "نص تجريبي",
        'id' => 1
    );

    $fields = array(
        'to' => $registration_ids,
        'notification' => $msg,
        "priority" => "high"
    );
    $headers = array(
        'Authorization: key=' . GOOGLE_API_KEY,
        'Content-Type: application/json'
    );
    // Open connection
    $ch = curl_init();

    // Set the url, number of POST vars, POST data
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Disabling SSL Certificate support temporarly
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //echo(json_encode($fields));die();
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

    // Execute post
    $result = curl_exec($ch);
    if ($result === FALSE) {
        return 0;
    }
    // Close connection
    curl_close($ch);
//        die();

    return $result;
}

function checkAdmin($id = 1)
{
    $admin = \App\Admin::where('email', '=', 'admin@admin.com')->where('id', '=', $id)->first();

    if ($id == session('admin')->id || $admin) {
        session()->flash('msg', 'لا يمكنك اجراء هذه العملية على الحساب الذي اخترته');
        return false;
    } else
        return true;
}

function avarage($arr)
{
    $count = $arr->count();
    if ($count) {
        return '$' . number_format($arr->sum('cost') / $count, 0);
    } else
        return 'لم يتم الحساب';
}

function EvaluateAvg($arr)
{
    if ($arr->count()) {
        $sum = $arr->sum('quality') +
            $arr->sum('experience') +
            $arr->sum('workAgain') +
            $arr->sum('ProfessionalAtWork') +
            $arr->sum('CommunicationAndMonitoring');
        return ($sum / $arr->count() / 5);
    } else
        return 0;
}

function stepUrl($type)
{
    switch ($type) {
        case 'editProfile':
            return '/editProfile';
        case 'mobileConfirm' :
            return '/editProfile#active_phone';

        case 'addProject':
            return '/addProject';
        case 'addPortoflio':
            return '/addPortfolio';
        case 'addbid':
            return '/projects';
    }
}

function avatar($avatar, $setting)
{
    if ($avatar && !str_contains($avatar, 'image_')) {
        if (str_contains($avatar, '?')) {
//             $avatar=preg_replace ('/width=\d*/i','width=200',$avatar);
            return $avatar;
        } else {
            return $avatar;
        }
    }
    $user_id = session('user')['id'];
    $user = \App\user::find($user_id);
    $male = \App\setting::where('set_id', 'MALE_AVATAR')->first(['set_data'])->set_data;
    $female = \App\setting::where('set_id', 'FEMALE_AVATAR')->first(['set_data'])->set_data;
    $imageType = $user ? ($user->gender == 1) ? asset('images/users/' . $male) : asset('images/users/' . $female) : '';
    return ($avatar) ? '/image_r/200/' . $avatar : $imageType;
}

function getNotifcationMessage($type, $username, $details)
{
    switch ($type) {
        case 'Administrative':
            break;
        case 'orderFinishRequest':
            return "طلب $username انهاء مشروع " . "$details الرجاء تأكيد انهاء المشروع .";
            break;
        case 'finishProject':
            return "قام  $username بانهاء المشروع: " . "$details";
            break;
    }
}

function getFreelancer($id)
{
    return (int)\App\projectFreelancer::where('project_id', $id)->first(['cost'])->cost;
}

function check_steps($user)
{
    $step = json_decode($user->finishProfileStep);

    $userType = $user->type;
    $steps2 = ['emailConfirm', 'editProfile', 'addProject'];
    $steps1 = ['emailConfirm', 'editProfile', 'addPortoflio', 'addbid'];
    $steps3 = ['emailConfirm', 'editProfile', 'addProject', 'addPortoflio', 'addbid'];
    $ret = [];
    switch ($userType) {
//    projectOwner
        case 1:
            foreach ($steps1 as $value) {
                $ret[$value] = isset($step->$value);
            }

            break;
        case 2:
//            freelancer
            foreach ($steps2 as $value) {
                $ret[$value] = isset($step->$value);
            }
            break;
        case 3:
//            both
            foreach ($steps3 as $value) {
                $ret[$value] = isset($step->$value);
            }
            break;
    }
    return $ret;
}

function checkCloseBid1($project, $setting, $type = 0)
{
    if (!$project->isBlock) {

        if ($project->status == 2) {
            if ($type || session('user')) {
                if (session('user')['isVIP']) {
                    //vip user
                    return 7;
                }
                if ($type || session('user')['status'] != 2) {
                    $date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $project->created_at);
                    $now = \Carbon\Carbon::now();
                    if ($now->diffInDays($date) > $setting['open_project_day']) {
//             project close
                        return 3;
                    } else {
                        return 1;
                    }
                } else {
                    return 5;
                }
            } else {
//            must login
                return 4;
            }

        } else {
//        submited close
            return 2;
        }

    } else {
        return 6;
    }
}

function checkCloseBid($project, $setting, $type = 0)
{
    $date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $project->created_at);
    $now = \Carbon\Carbon::now();
    if ($type || !session('user')) {
        return 4; //must login
    } else if ($project->isBlock) {
        return 3; //this project is blocked
    } else if ($project->status == 5) {
        return 2; //project is closed
    } else if ($project->status != 2) {
        return 2; // انتهى التقديم لهذا المشروع
    } else if (session('user')['isVIP']) {
        return 7;  // you can not submit for this project your account vip
    } else if (session('user')['status'] == 2) {
        return 5; // your account is blocked by adminstration
    } else if ($now->diffInDays($date) > $setting['open_project_day']) {
        return 3; // project closed
    } else {
        return 8; //you can add bid
    }
}

function minMaxday($val)
{
    switch ($val) {
        case 1:
            $rs = ['min' => 1, 'max' => 5];
            break;
        case 2:
            $rs = ['min' => 5, 'max' => 10];
            break;
        case 3:
            $rs = ['min' => 10, 'max' => 25];
            break;
        case 4:
            $rs = ['min' => 25, 'max' => 50];
            break;
        case 5:
            $rs = ['min' => 50, 'max' => 80];
            break;
        case 6:
            $rs = ['min' => 80, 'max' => 200];
            break;
    }

    return $rs;
}

function getDay($date)
{
    $date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date);
    $now = \Carbon\Carbon::now();
    \Carbon\Carbon::setLocale('ar');
    return $date->diffInDays($now);
}

function dateToString($date)
{
    $date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date);
    $now = \Carbon\Carbon::now();
    \Carbon\Carbon::setLocale('ar');
    return $date->diffForHumans($now);
}

function getFormatDaysFromDate($date)
{
    $date1 = new DateTime($date);
    $date2 = new DateTime(\Carbon\Carbon::now());
    $check = $date2->diff($date1)->format("%a");
    if ($check == 0) {
        return dateToString($date);
    }
    if ($check == 1) {
        return "يوم";
    } elseif ($check == 2) {
        return "يومين";
    } elseif ($check >= 3 && $check <= 10) {
        return $check . " ايام";
    } else {
        return $check . " يوماً";
    }

}

function getProjectBudget($id)
{
    $project = \App\projectFreelancer::where('project_id', $id)->first();

    if ($project)
        return $project->cost;
}

function getProjectSpecialization($id)
{
    $project =  \App\project::find($id);

    if ($project) 
        return $project->specialization->name;
}

function getFormatDaysFromNumber($number)
{
    if ($number == 1) {
        return "يوم";
    } elseif ($number == 2) {
        return "يومين";
    } elseif ($number >= 3 && $number <= 10) {
        return $number . " ايام";
    } else {
        return $number . " يوماً";
    }

}

function isOnline($date)
{
    if ($date) {
        $date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date);
        $now = \Carbon\Carbon::now();
        $diffInMinutes = $now->diffInMinutes($date);

        return ($diffInMinutes < 15);
    } else {
        return 0;
    }
}

function projectcolor($project, $setting)
{
    if ($project->isBlock)
        return 'redsq';
    $check = \App\caneclProject::where('project_id', $project->id)->count();
    if ($check != 0)
        return 'blackq';
    switch ($project->status) {
        case 1:
            return 'openProjectColor';
        case 2:
            $date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $project->created_at);
            $now = \Carbon\Carbon::now();
            if ($now->diffInDays($date) < $setting['open_project_day']) {
                return 'greensq';
            } else {
                return 'closered';
            }
        case 3:
            return 'yellowsq';
        case 4:
            return 'blackq';
        case 5:
            return 'closered';
        case 6:
            return 'darkblue';
    }
}

function projectStatus($project, $setting)
{
    if ($project->isBlock)
        return 'محظور';
    $check = \App\caneclProject::where('project_id', $project->id)->count();
    if ($check != 0)
        return 'ملغي';
    switch ($project->status) {
        case 1:
            return 'بإنتظار الموافقة';
        case 2:
            $date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $project->created_at);
            $now = \Carbon\Carbon::now();
            if ($now->diffInDays($date) < $setting['open_project_day']) {
                return 'مفتوح';
            } else {
                return 'مغلق';
            }

        case 3:
            return 'قيد التنفيذ';
        case 4:
            return 'ملغي';
        case 5:
            return 'مغلق';
        case 6:
            return 'مكتمل';
    }
}

function bidStatus($bid, $project, $setting)
{
    if ($bid->isBlock)
        return 'محظور';
    // $check = \App\bid::where(['project_id' => $project->id])->where('status', 2)->orWhere('status', 3)->where('freelancer_id', session('user')['id'])->count();

    // dd($check);
    
    // if (!$check)
    //     return 'مستبعد';

    if (projectStatus($project, $setting) == 'مغلق')
        return 'مغلق';

    if (!$bid->isBlock) {
        switch ($bid->status) {
            case 1:
                $date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $project->created_at);
                $now = \Carbon\Carbon::now();
                if ($now->diffInDays($date) < $setting['open_project_day']) {
                    return 'بإنتظار الموافقة';
                } else {
                    return 'مغلق';
                }

            case 2:
                return 'قيد التنفيذ';
            case 3:
                return 'مكتمل';
            case 4:
                return 'ملغي';
            case 5:
                return 'مغلق';
            case 6:
                return 'مستبعد';
            case 7:
                return 'محظور';
        }
    } else {
        return 'مستبعد';
    }
}

function bidcolor($bid, $project, $setting)
{
    if ($bid->isBlock)
        return 'closered';
    // $check = \App\bid::where(['project_id' => $project->id])->where('status', 2)->orWhere('status', 3)->where('freelancer_id', session('user')['id'])->count();
    // if (!$check)
    //     return 'redsq';

    if (projectStatus($project, $setting) == 'مغلق')
        return 'closered';

    switch ($bid->status) {
        case 1:
            $date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $project->created_at);
            $now = \Carbon\Carbon::now();
            if ($now->diffInDays($date) < $setting['open_project_day']) {
                return 'openProjectColor';
            } else {
                return 'closered';
            }

        case 2:
            return 'yellowsq';
        case 3:
            return 'darkblue';
        case 4:
            return 'blackq';
        case 5:
            return 'closered';
        case 6:
            return 'redsq';
        case 7:
            return 'redsq';
    }
}


function projecticon($project, $setting)
{
    if ($project->isBlock)
        return 'fa fa-eye-slash';
    // $check = \App\caneclProject::where('project_id', $project->id)->count();
    // if ($check != 0)
    //     return 'fa fa-times';
    switch ($project->status) {
        case 1:
            return 'icon-loadingprocess';
        case 2:
            $date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $project->created_at);
            $now = \Carbon\Carbon::now();
            if ($now->diffInDays($date) < $setting['open_project_day']) {
                return 'icon-time';
            } else {
                return 'fa fa-times';
            }


        case 3:
            return 'icon-time';
        case 4:
            return 'fa fa-times';
        case 5:
            return 'fa fa-times';
        case 6:
            return 'icon-checked';
    }
}


function bidicon($bid, $project, $setting)
{
    if ($project->isBlock)
        return 'icon-times';
    switch ($bid->status) {
        case 1:
            $date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $project->created_at);
            $now = \Carbon\Carbon::now();
            if ($now->diffInDays($date) < $setting['open_project_day']) {
                return 'icon-time';
            } else {
                return 'fa fa-times';
            }

        case 2:
            return 'icon-time';
        case 3:
            return 'icon-checked';
        case 4:
            return 'fa fa-times';
    }
}


function _c($val, $atr)
{
    if (isset($val))
        return $val->$atr;
    else
        return '';
}

function notificationUrl($type, $type_id)
{
    $url='';
    switch ($type) {
        case 1:
            $url = '/notifcations';
            break;
        case 2:
            $url = '/project/' . $type_id;
            break;

        case 3:
            $url = '/project/' . $type_id;
            break;
        case 4 :
            $url = '/project/' . $type_id;
            break;
        case 5 :
            $url = '/project/' . $type_id;
            break;

        case 6:
            $url = '/project/' . $type_id;
            break;
        case 7 :
            $url = '/project/' . $type_id;
            break;
        case 8 :
            $url = '/project/' . $type_id;
            break;
        case 9:
            $url = '/singleUser/' . $type_id;
            break;
        case 10:
            $url = '/project/' . $type_id;
            break;
        case 11:
            $url = '/conversation/' . $type_id;
        case 12:
            $url = '/project/' . $type_id;
            break;
    }
    return $url;
}

function check_recaptcha($response)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, 'secret=6LfSexoUAAAAAOmhFVQOxUOPP71Wjbux1L8Jc-68&response=' . $response);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $server_output = curl_exec($ch);

    curl_close($ch);
    $server_output = json_decode($server_output);
    return $server_output->success;
}

function send_simple_message($email, $title, $msg)
{

    if (is_array($email)) {
        $email = implode(',', $email);
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, 'api:key-6bb5089208b3a08c286d6971ba967e37');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_URL, 'https://api.mailgun.net/v3/globaleyes.dev-ahmed.com/messages');
    curl_setopt($ch, CURLOPT_POSTFIELDS, array('from' => 'عيون العالم <globaleyes@globaleyes.sa>',
        'to' => 'orders@globaleyes.sa',
        'bcc' => $email,
        'subject' => $title,
        'html' => $msg));
    $result = curl_exec($ch);
    curl_close($ch);
    // print_r(  $result);die();
    return $result;
}

function encode_url($url, $txt)
{
    $txt = str_replace(' ', '-', $txt);
    return $url . '-' . $txt;
}

function avgResponseSpead($minuts)
{
    if ($minuts) {
        $date = \Carbon\Carbon::now()->subseconds($minuts);
        return str_replace('قبل', '', dateToString($date));
    } else {
        return 'لم يتم حسابه';
    }
}

function getDateFromTime($date)
{

    return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->toDateString();
}

function getUserFromProject($id)
{
    $userId = \App\projectFreelancer::where('project_id', $id)->first();
//    dd($userId);
    return \App\user::find($userId->freelancer_id);
}

function getUserState($user)
{
    if ($user->status == 2) {
        return 'محظور';
    } else {
        return 'فعال';
    }
}

function getUserType($type)
{
    if ($type == 2) {
        return 'صاحب مشروع';
    } else if ($type == 1) {
        return 'منجز مشاريع';
    }
    return 'صاحب ومنجز مشاريع';
}

function checkPerm($segment3)
{
    $segment1 = request()->segment(1);
    $segment2 = request()->segment(2);
    $path = '/' . $segment1 . '/' . $segment2 . '/' . $segment3;
    return isset(session('scope')[$path]);
}

function checkPermFull($url)
{
    return isset(session('scope')[$url]);
}

function textInput($name, $defaultVal, $label, $type = 'text', $attr = 'required minlength=3 maxlength=150')
{
    $html = "<div class='form-group'>"
        . "<label>$label</label>"
        . "<input type='$type' class='form-control' $attr name='$name' value='$defaultVal'/>"
        . "</div>";
    return $html;
}

function numberInput($name, $defaultVal, $label, $attr = 'required')
{
    $html = "<div class='form-group'>"
        . "<label>$label</label>"
        . "<input type='number' class='form-control' $attr name='$name' value='$defaultVal'/>"
        . "</div>";
    return $html;
}

function textareaInput($name, $defaultVal, $label, $attr = 'required')
{
    $html = "<div class='form-group'>"
        . "<label>$label</label>"
        . "<textarea type='text' class='form-control' $attr name='$name' >$defaultVal</textarea>"
        . "</div>";
    return $html;
}

function arrayCount($array, $type)
{
    $count = 0;
    for ($i = 0; $i < sizeof($array); $i++) {
        if ($array[$i]->type == $type) {
            $count++;
        }
    }

    return $count;
}

function sendSMS($mobile, $text)
{
//send sms here

    $sid = 'AC4bad3f98adaa6a0e3ff3a717652a1920';
    $token = '7b9e101a044d306c6644b09d48362209';
    $client = new \Twilio\Rest\Client($sid, $token);
    try {

        $msg = $client->messages->create(
        // the number you'd like to send the message to
            $mobile,
            array(
                // A Twilio phone number you purchased at twilio.com/console
                'from' => '+15856104322',
                // the body of the text message you'd like to send
                'body' => $text
            )
        );

        $json['status'] = 1;
        $json['msg'] = 'تم ارسال الرسالة';
        return $json;

    } catch (Exception  $e) {
        // To catch exactly error 400 use
        $json['status'] = 0;
        $msg = trans('er-' . $e->getCode());
        if (!$msg)
            $msg = 'خطا غير مسجل : ' . $e->getCode();

        $json['msg'] = $msg;
        return $json;
    }
}


function checkType($segment)
{
    $owner = ['addProject', 'freelancers', 'addPrivateProject'];
    $provider = ['addBid', 'portfolios', 'addPortfolio'];
    $type = 0;
    if (array_search($segment, $provider) !== false) {
        $type = 1;
    } else if (array_search($segment, $owner) !== false) {
        $type = 2;
    }

    if ((session('user')['type'] == 1 && $type == 2)) {
        session()->flash('error', 'يجب ان يكون حسابك صاحب مشاريع ');
        return 0;
    } else if (session('user')['type'] == 2 && $type == 1) {
        session()->flash('error', 'يجب ان يكون حسابك مقدم مشاريع ');
        return 0;

    } else
        return 1;
}


///////////////////////////////////////////////////////////////////////////
// new functions added by me
function sendNotification($content, $oneSignalToken, $type, $url)
{
    foreach ($content as $key => $value) {
        $content[$key] = $value . '';
    }


    if (!is_array($oneSignalToken)) {
        $oneSignalToken = array($oneSignalToken);
    }
    $fields = array(
        'app_id' => '8d75b56d-231c-4f54-a2fb-f24a5cf5c235',
        'contents' => $content,
        'data' => array('message' => $content['en'], 'type' => $type),
        'include_player_ids' => $oneSignalToken,
        'url' => $url,
    );
    $fields = json_encode($fields);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
        'Authorization:Basic ZGUyZTJkYjMtNjNiYS00ZmRiLWI2YTEtNDE3ZGViMmVkMzE1'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    $response = curl_exec($ch);
    curl_close($ch);

//    echo( $response);
}

function getProjectCost($id)
{
    $p = \App\projectFreelancer::where('project_id', $id)->first(['cost']);
    return isset($p) ? $p->cost : 0;
}

function getFileType($name)
{
    $arr = [];
    $types = \App\fileType::all();

    foreach ($types as $type) {
        if (in_array($name, json_decode($type->type))) {
            array_push($arr, $type->extension);
        }
    }
    return implode(',', $arr);
}

function getAllFileType()
{
    $types = \App\fileType::pluck('extension')->toArray();
    return implode(',', $types);
}

function isCloseProject($id)
{
    return \App\caneclProject::where('project_id', $id)->count() == 0 ? 0 : 1;

}

function isExcludedBid($id)
{
    $check = \App\bid::where(['project_id' => $id])->where('status', 2)->orWhere('status', 3)->where('freelancer_id', session('user')['id'])->count();

    if (!$check) {
        return 1; //mean excluded
    }
    return 0;
}

function getProjectEndedDate($date, $duration)
{
    return \Carbon\Carbon::parse($date)->addDays($duration)->format('Y-m-d');
}