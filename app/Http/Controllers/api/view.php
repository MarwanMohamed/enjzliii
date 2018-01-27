<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\user;

class view extends Controller
{

    function unseenCount()
    {
        global $user;
        $unseenNotifications = \App\notifcation::where(['user_id'=> $user['id'],'seen_api'=>0])->latest()->count();
        $unseenMessages = \App\message::where(['reciever_id'=> $user['id'],'seen_api'=>0])->latest()->get()->unique('conversation_id')->count();
        $json['unseenMessage'] = $unseenMessages;
        $json['unseenNoti'] = $unseenNotifications;
        return response($json);
    }


    function noti(Request $request)
    {
        global $user;
        $notifcations = \App\notifcation::where('user_id', $user['id'])->latest()->paginate(10)->map(function ($item) {
            \Carbon\Carbon::setLocale('ar');
            return [
                'title' => $item->title,
                'details' => $item->details,
                'url' => url('/').'/notifcation/'.$item->id,
                'seen' => $item->seen_api,
                'created_at' => $item->created_at->format('j F Y'),
            ];
        });
        $pagination = \App\notifcation::where('user_id', $user['id'])->latest()->paginate(10)->toArray();

        $paged = 1;
        if($request['page']) {
            $paged = $request['page'];
            \App\notifcation::where('user_id', $user['id'])->latest()->take(10)->offset($paged)->update(['seen_api' => 1]);
        }
        if(empty($pagination['next_page_url'])){
            \App\notifcation::where('user_id', $user['id'])->update(['seen_api' => 1]);
        }

        $json['notifcations'] = \App\notifcation::where('user_id', $user['id'])->with('owner')->latest()->get();

        $unseen = 0;
        foreach ($json['notifcations'] as $key => $value) {
            if (!$value->seen)
                $unseen++;
        }
        $json['unseenNoti'] = $unseen;
        return response([
            'total' => $pagination['total'],
            'per_page' => $pagination['per_page'],
            'current_page' => $pagination['current_page'],
            'last_page' => $pagination['last_page'],
            'next_page_url' => $pagination['next_page_url'],
            'prev_page_url' => $pagination['prev_page_url'],
            'from' => $pagination['from'],
            'to' => $pagination['to'],
            'data' => $notifcations

        ]);
    }

    function message(Request $request)
    {
        global $user;

        user::where('id', $user['id'])->update(['lastLogin' => date('y-m-d H:i:s')]);


        $pagination = \App\message::where(['reciever_id' => $user['id']])->orWhere('VIPUser', $user['id'])->latest()->paginate(10)->toArray();

        $messages = \App\message::where(['reciever_id' => $user['id']])->orWhere('VIPUser', $user['id'])->latest()->paginate(10)->map(function ($item) {
            $title = \App\conversation::find($item->conversation_id)->project->title;
            $user = \App\user::find($item->sender_id);
            $path = route('avatar', ['user' => $user->avatar ?: 'image_avatar.png']);
            $path = (strpos($path, 'graph.facebook.com') > 0) ? str_replace(url('api/v1/avatar/') . '/', '', $path) : $path;

            return [
                'title' => $title,
                'image' => $path,
                'content' => $item->content,
                'seen' => $item->seen_api,
                'conversation_id' => $item->conversation_id,
                'url' => url('/').'/conversation/'.$item->id,
                'created_at' => $item->created_at->format('j F Y'),
            ];
        })->unique('conversation_id');

        $paged = 1;
        if($request['page']) {
            $paged = $request['page'];
            \App\message::where(['reciever_id' => $user['id']])->orWhere('VIPUser', $user['id'])->latest()->take(10)->offset($paged)->update(['seen_api' => 1]);
        }

        return response([
            'total' => $pagination['total'],
            'per_page' => $pagination['per_page'],
            'current_page' => $pagination['current_page'],
            'last_page' => $pagination['last_page'],
            'next_page_url' => $pagination['next_page_url'],
            'prev_page_url' => $pagination['prev_page_url'],
            'from' => $pagination['from'],
            'to' => $pagination['to'],
            'data' => $messages
        ]);


    }

    function messageSeen($id)
    {
        \App\message::whereId($id)->update(['seen' => 1]);
        $json['status'] = 1;
        return response($json);
    }

    function notiSeen($id)
    {
        \App\notifcation::whereId($id)->update(['seen' => 1]);
        $json['status'] = 1;
        return response($json);
    }

}
