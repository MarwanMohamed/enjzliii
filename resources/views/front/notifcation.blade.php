<style>
    ul.head-menu5 li ul li a.seen-noti {
        color: black !important;
        position: absolute;
        width: auto;

        top: 10px;
    }

    .seen-noti i {
        color: black !important;
        font-size: 10px !important;

    }
</style>
<a href="/notifcations" class="mobilePrevent" style="padding: 0;"><i
            class="icon-alarm"></i>@if(isset($templateData['unseenNoti']) && $templateData['unseenNoti']>0)
        <span>{{$templateData['unseenNoti']}}</span>@endif</a>
<ul>
    @if(isset($templateData['notifcations']))
        @forelse($templateData['notifcations'] as $value)
            @if($value->project_id == 0)
                <li style="{!! (!$value->seen)? 'background:#f5f5f5;' : '' !!} postion:relative ">
                    <div class="noti_img">
                        <img src='{!! $value->avatar() !!}'>
                    </div>
                    <a href="{{$value->type_id==0?'/notifcations/':('/notifcation/'.$value->id)}}" style="width: 79%;    background: none;">
                        <div class="text_emails">
                            <h2><strong>{{$value->title}}</strong><br>{{str_limit($value->details,80) }}</h2>
                            <p><i class="icon-time "></i>{{dateToString($value->created_at)}}</p>
                        </div>
                    </a>
                    @if(!$value->seen)
                        {{--       <a href="/notifcation/seen/{{$value->id}}"  class='seen-noti ajaxRequest'><i class='fa fa-dot-circle-o '></i></a> --}}
                    @endif
                </li>
            @endif
        @empty
            <li>
                <a href="#javascript">

                    <div class="text_email" style="padding-right:25%">
                        <p style="font-size: 18px;color: red;">لا يوجد اشعارات</p>
                    </div>
                </a>
            </li>
        @endforelse
        @if(count($templateData['notifcations']))
            <li>
                <a href="/notifcations" class="more_massage">جميع الأشعارات</a>
            </li>

        @endif
    @endif
</ul>