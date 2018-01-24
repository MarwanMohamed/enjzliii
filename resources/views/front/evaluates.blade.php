<?php global $setting;?>
@foreach($evaluates as $evaluate)
    <div class="item_h2ss padding_have">
    <div class="ppl_rate">
        <div class="img_ppl">
            <?php $avatar=$evaluate->avatar;?>
            <a href="javascript:;"><img src="{{avatar($avatar,$setting)}}"></a>
        </div>
        <div class="info_ppl">
            <a href="#"><h2>{{$evaluate->fname.' '.$evaluate->lname}}</h2></a>
            <ul>
                <li><i class="icon-time"></i>{{getFormatDaysFromDate($evaluate->created_at)}}</li>
                <li><i class="icon-folder2"></i>{{$evaluate->specialization}}</li>
                <li><i class="icon-location"></i>{{$evaluate->country_name}}</li>
            </ul>
        </div>
    </div>
    <div class="for_rating">
        <span>
            <i class="icon-reply2"></i>
            <p>على</p>
        </span>
        <div class="info_ppl">
            <a href="{{encode_url('/project/'.$evaluate->project_id,$evaluate->project_title)}}"><h2>{{$evaluate->project_title}}</h2></a>
            <ul>
                <li><i class="icon-user1"></i>{{getProjectSpecialization($evaluate->project_id)}}</li>
                <li><i class="icon-time"></i>{{getFormatDaysFromNumber($evaluate->deliveryDuration)}}</li>
                {{-- {{dd(123)}} --}}
                <li><i class="icon-moneybag"></i>الميزانية {{getProjectBudget($evaluate->project_id)  }}</li>
            </ul>
        </div>
    </div>
    <div class="divt_rate">
        <div class="first_rate">
            <h2>الإحترافية بالتعامل</h2>
            <ul>
                @for($i=0 ;$i<5;$i++)
                    <li class="{{($i<$evaluate->ProfessionalAtWork)?'active':''}}"><i class="icon-star"></i></li>
                @endfor
                <li>{{$evaluate->ProfessionalAtWork}}</li>
            </ul>
        </div>
        <div class="first_rate">
            <h2>التواصل والمتابعة</h2>
            <ul>
                @for($i=0 ;$i<5;$i++)
                    <li class="{{($i<$evaluate->CommunicationAndMonitoring)?'active':''}}"><i class="icon-star"></i></li>
                @endfor
                <li>{{$evaluate->CommunicationAndMonitoring}}</li>
            </ul>
        </div>
        <div class="first_rate">
            <h2>جودة العمل المسلّم </h2>
            <ul>
                @for($i=0 ;$i<5;$i++)
                    <li class="{{($i<$evaluate->quality)?'active':''}}"><i class="icon-star"></i></li>
                @endfor
                <li>{{$evaluate->quality}}</li>
            </ul>
        </div>
        <div class="first_rate">
            <h2>الخبرة بمجال المشروع </h2>
            <ul>
                @for($i=0 ;$i<5;$i++)
                    <li class="{{($i<$evaluate->experience)?'active':''}}"><i class="icon-star"></i></li>
                @endfor
                <li>{{$evaluate->experience}}</li>
            </ul>
        </div>
        <div class="first_rate">
            <h2>التعامل معه مرّة أخرى </h2>
            <ul>
                @for($i=0 ;$i<5;$i++)
                    <li class="{{($i<$evaluate->workAgain)?'active':''}}"><i class="icon-star"></i></li>
                @endfor
                <li>{{$evaluate ->workAgain}}</li>
            </ul>
        </div>
    </div>
    <h2 class="answ_ppl">{{$evaluate->note}}</h2>
</div>
@endforeach
<div class="evaluatePage">
    {{$evaluates->links()}}
</div>