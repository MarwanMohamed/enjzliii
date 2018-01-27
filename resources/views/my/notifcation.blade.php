<style>
    .date {
        font-size: 12px;
        display: block;
    }

    .username {
        color: #fe5339;
    }

    .noti_img img {
        margin: 0px;
        margin-left: 10px;
        margin-right: 20px;
    }

    .noti_img {
        margin-top: 20px;
    }

    @media screen and (max-width: 765px) {
        span.date {
            position: initial;
            display: block;
            padding: 0;
        }

        .massage_itempage .noti_img {
            width: 30%;
            text-align: center;
        }

        span.username {
            display: inline-block;
            font-size: 12px;
        }
    }
</style>
<?php global $setting?>
@foreach($notifcations as $notifcation)
    <div class="massage_itempage" {!!(!$notifcation->seen)?'style=background:#efefef':''!!}>
        <div class='noti_img'><img src='{{$notifcation->avatar()}}'>
            <span class="username">{{$notifcation->fullname()}}</span>
            <span class="date">{{getFormatDaysFromDate($notifcation->created_at)}}</span>
        </div>
        <div class="item_massageprof">
            <a href="{{$notifcation->type_id==0?'javascript:;':('/notifcation/'.$notifcation->id)}}">
                <h2>{{$notifcation->title}}</h2></a>
            <a href="{{$notifcation->type_id==0?'javascript:;':('/notifcation/'.$notifcation->id)}}">
                <p>{{$notifcation->details}}</p></a>
        </div>
    </div>
@endforeach
@if(!sizeof($notifcations))
    <div class="massage_itempage">
        <h2 style="margin:100px  40%">لا يوجد بيانات</h2>
    </div>
@endif
<div class="publicPaginate">
    @include('pagination.limit_links', ['paginator' => $notifcations])
</div>