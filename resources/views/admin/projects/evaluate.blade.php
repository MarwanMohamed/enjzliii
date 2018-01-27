<?php global $setting;?>
<style>

    .img_ppl img {
        float: right;
        width: 60px;
        height: 60px;
    }
    .info_ppl h2 {
        float: right;
        width: 100%;
        color: #fe5339;
        font-size: 16px;
        font-weight: bold;
    }
    .info_ppl ul li {
        float: right;
        margin-left: 10px;
        font-size: 10px;
        color: #acacac;
    }
    .info_ppl {
        float: right;
    }
    .ppl_rate {
        float: right;
        width: 100%;
        margin-bottom: 10px;
    }
    .for_rating {
        float: right;
        width: 100%;
        display: flex;
    }
    .for_rating span {
        border-radius: 5px;
        width: 50px;
        height: 50px;
        float: right;
        background: #fe5339;
        text-align: center;
        padding: 5px;
        overflow: hidden;
        font-size: 12px;
        color: #fff;
        margin-left: 10px;
    }
    .info_ppl ul {
        float: right;
        width: 100%;
    }
    ol, ul {
        list-style: none;
    }

    .info_ppl h2 {
        float: right;
        width: 100%;
        color: #fe5339;
        font-size: 16px;
        font-weight: bold;
    }
    .item_h2ss .first_rate {
        font-size: 14px;
        font-weight: bold;
        color: #787878;
        padding: 5px 0;
    }
    .first_rate h2 {
        float: right;
        color: #787878;
        font-size: 14px;
    }
    .first_rate {
        float: right;
        width: 100%;
        padding: 10px 0;
        margin-bottom: 10px;
        border-bottom: 1px solid #f6f6f6;
    }
    .item_h2ss .divt_rate {
        border-top: 1px solid #f6f6f6;
        padding: 10px 20px;
        margin-bottom: 0px;
    }
    .divt_rate {
        float: right;
        width: 100%;
        margin: 20px 0;
        background: #fff;
        padding: 30px 20px;
        border-radius: 5px;
    }
    .first_rate ul {
        float: left;
        padding: 0px 5px;
    }
    .item_h2ss .first_rate ul li {
        font-size: 16px;
        color: #9e9e9e;
    }
    .first_rate ul li {
        float: right;
        padding: 0px 3px;
        color: #9e9e9e;
        font-size: 18px;
        text-align: center;
    }
    .text_left_imgasq ul li.active i, .text_result ul li.active i, .text_divprof ul li.active i, .ifno_item_ppl ul li.active i, .first_rate li.active i {
        color: #ffc107;
    }
    .text_left_imgasq ul li i, .text_divprof ul li i, .ifno_item_ppl ul li i, .first_rate ul li i, .text_result ul li i {
        font-size: 10px;
        color: #e5e6e8;
    }

    [class^="icon-"], [class*=" icon-"] {
        font-family: 'icomoon' !important;
        speak: none;
        font-style: normal;
        font-weight: normal;
        font-variant: normal;
        text-transform: none;
        line-height: 1;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }
</style>
@foreach($user->freelancerEvaluates as $evaluate)
    <div class="item_h2ss padding_have">
        <div class="ppl_rate">
            <div class="img_ppl">
                <?php $avatar=$evaluate->avatar;?>
                <a href="javascript:;"><img src="{{avatar($avatar,$setting)}}"></a>
            </div>
            <div class="info_ppl">
                <a href="#"><h2>{{$evaluate->evalutedUser->fullname()}}</h2></a>
                <ul>
                    <li><i class="icon-time"></i>{{($evaluate->created_at)}}</li>
                </ul>
            </div>
        </div>
        <div class="for_rating">
        <span>
            <i class="icon-reply2"></i>
            <p>على</p>
        </span>
            <div class="info_ppl">
                <a href="{{encode_url('/project/'.$evaluate->project->id,$evaluate->project->title)}}"><h2>{{$evaluate->project->title}}</h2></a>
                <ul>
                    <li><i class="fa fa-clocl-o"></i>{{$evaluate->project->deliveryDuration.' يوم'}}</li>
                </ul>
            </div>
        </div>
        <div class="divt_rate">
            <div class="first_rate">
                <h2>الإحترافية بالتعامل</h2>
                <ul>
                    @for($i=0 ;$i<5;$i++)
                        <li class="{{($i<$evaluate->ProfessionalAtWork)?'active':''}}"><i class=" fa fa-star"></i></li>
                    @endfor
                    <li>{{$evaluate->ProfessionalAtWork}}</li>
                </ul>
            </div>
            <div class="first_rate">
                <h2>التواصل والمتابعة</h2>
                <ul>
                    @for($i=0 ;$i<5;$i++)
                        <li class="{{($i<$evaluate->CommunicationAndMonitoring)?'active':''}}"><i class=" fa fa-star "></i></li>
                    @endfor
                    <li>{{$evaluate->CommunicationAndMonitoring}}</li>
                </ul>
            </div>
            <div class="first_rate">
                <h2>جودة العمل المسلّم </h2>
                <ul>
                    @for($i=0 ;$i<5;$i++)
                        <li class="{{($i<$evaluate->quality)?'active':''}}"><i class=" fa fa-star"></i></li>
                    @endfor
                    <li>{{$evaluate->quality}}</li>
                </ul>
            </div>
            <div class="first_rate">
                <h2>الخبرة بمجال المشروع </h2>
                <ul>
                    @for($i=0 ;$i<5;$i++)
                        <li class="{{($i<$evaluate->experience)?'active':''}}"><i class=" fa fa-star"></i></li>
                    @endfor
                    <li>{{$evaluate->experience}}</li>
                </ul>
            </div>
            <div class="first_rate">
                <h2>التعامل معه مرّة أخرى </h2>
                <ul>
                    @for($i=0 ;$i<5;$i++)
                        <li class="{{($i<$evaluate->workAgain)?'active':''}}"><i class=" fa fa-star"></i></li>
                    @endfor
                    <li>{{$evaluate ->workAgain}}</li>
                </ul>
            </div>
        </div>
        <h2 class="answ_ppl">{{$evaluate->note}}</h2>
    </div>
    <hr>
@endforeach

@if(!sizeof($user->freelancerEvaluates))
    <div>لا يوجد تقيمات</div>
@endif