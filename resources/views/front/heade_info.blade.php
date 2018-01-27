<?php global $setting; ?>
<section class="s_404">
    <div class="container">
        <!--           <style>
                .list_profile1 li{
                    width: 18%;
                }
            </style> -->
        <div class="heade_divprof">
            <div class="first_divprof">

                <div class="img_divprof">
                    <a href="#"><img width="100%" height="100%"
                                     src="{{ !empty(avatar($user->avatar,$setting))?avatar($user->avatar,$setting):$imageType}}"
                                     title="user"></a>
                </div>
                <div class="text_divprof">
                    <a href="#"><h2>{{$user->fname.' '.$user->lname}}</h2></a>
                    <?php
                    //                    $evaluate=number_format(($user->ProfessionalAtWork+
                    //                            $user->CommunicationAndMonitoring+
                    //                            $user->quality+
                    //                            $user->experience+
                    //                            $user->workAgain)/5,0);
                    $avr = $user->stars;
                    ?>
                    <ul>
                        {{--@for($i=0 ;$i<5;$i++)--}}
                        {{--<li class="{{($i<$evaluate)?'active':''}}"><i class="icon-star"></i></li>--}}
                        {{--@endfor--}}
                        @for($i=0;$i<5;$i++)
                            @if($i<$avr)
                                <li class="active"><i class="icon-star"></i></li>
                            @else
                                <li><i class="icon-star"></i></li>
                            @endif
                        @endfor
                        {{--<li>{{$evaluate}}</li>--}}
                        <li>{{$avr}}</li>
                        <h3><span><i id="{{(isOnline($user->lastLogin))?'active':''}}" class="fa fa-circle"
                                     aria-hidden="true"></i></span> {{isOnline($user->lastLogin)?'متصل':'غير متصل'}}
                        </h3>
                        <h3><span><i class="icon-folder1"></i></span> {{$user->specialization_name}}</h3>
                        <h3><span><i class="icon-location"></i></span> {{$user->country_name}}</h3>
                        <h3><span><i class="fa fa-address-book-o"></i></span> {{(getUserType($user->type))}}</h3>
                    </ul>
                </div>
            </div>
            <ul class="list_profile list_profile1">

                {{--<li>--}}
                {{--<i class="icon-checked"></i>--}}
                {{--<h2>المشاريع المستلمة</h2>--}}
                {{--<p>{{$statistics->deliverProjectCount}}</p>--}}
                {{--</li>--}}

                {{--<li>--}}
                {{--<i class="icon-folder2"></i>--}}
                {{--<h2>المشاريع المكتملة</h2>--}}
                {{--<p>{{$statistics->finishProjectCount}}</p>--}}
                {{--</li>--}}
                {{--<li>--}}
                {{--<i class="icon-alarm-clock"></i>--}}
                {{--<h2>المشاريع قيد التنفيذ</h2>--}}
                {{--<p>{{$statistics->progressProjectCount}}</p>--}}
                {{--</li>--}}
                {{--<li class="hidden">--}}
                {{--<i class="icon-loadingprocess"></i>--}}
                {{--<h2>معدل اكمال المشاريع</h2>--}}
                {{--<p>{{($statistics->cancelProjectCount+$statistics->finishProjectCount)?($statistics->finishProjectCount/($statistics->cancelProjectCount+$statistics->finishProjectCount))*100 .'%':'لم يتم الحساب بعد'}}</p>--}}
                {{--</li>--}}
                @if($user->type == 1 || $user->type == 3)
                    {{--<li>--}}
                        {{--<i class="icon-checked"></i>--}}
                        {{--<h2>المكتملة</h2>--}}
                        {{--<p>{{$complete}}</p>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<i class="fa fa-ticket"></i>--}}
                        {{--<h2>عدد العروض</h2>--}}
                        {{--<p>{{$bids_count}}</p>--}}
                    {{--</li>--}}

                @endif
                {{--@if($user->type == 2 || $user->type == 3)--}}
                    {{--<li>--}}
                        {{--<i class="fa fa-suitcase"></i>--}}
                        {{--<h2>المشاريع المستلمة</h2>--}}
                        {{--<p>{{$projects_count}}</p>--}}
                    {{--</li>--}}
                {{--@endif--}}
              
                @if(getUserType($user->type) == 'صاحب ومنجز مشاريع')
                    <li>
                        <i class="fa fa-table"></i>
                        <h2>المشاريع المكتملة</h2>
                        <p>{{$projects_complete_count}}</p>
                    </li>
                    <li>
                        <i class="fa fa-th-list"></i>
                        <h2>العروض المكتملة</h2>
                        <p>{{$complete}}</p>
                    </li>

                    @elseif(getUserType($user->type) == 'منجز مشاريع')
                        
                    <li>
                        <i class="fa fa-th-list"></i>
                        <h2>العروض المكتملة</h2>
                        <p>{{$complete}}</p>
                    </li>
                    @else
                    <li>
                        <i class="fa fa-table"></i>
                        <h2>المشاريع المكتملة</h2>
                        <p>{{$projects_complete_count}}</p>
                    </li>
                    @endif
                <li>
                    <i class="icon-runer-silhouette-running-fast"></i>
                    <h2>متوسط سرعة الرد</h2>
                    <p>{{avgResponseSpead($user->responseSpeed)}}</p>
                </li>
                <li>
                    <i class="icon-clock"></i>
                    <h2>أخر تواجد</h2>
                    <p>{{dateToString($user->lastLogin)}}</p>
                </li>


            </ul>
            @if($user->type>1 && session('user')['id']!= $user->id)
                <div class="row">

                    {{--<a href="javascript:;" data-name="{{$bid->user->fullname()}}" data-info="{{$bid->cost}}" data-href="/addFreelancer?bid_id={{$bid->id}}" id="chooseFreelancer" class="customButton confirmBidsClick">اطلبني <span class="fa fa-spin fa-spinner hidden"  id="chooseFreelancerLoader"></span></a>--}}

                    <div class="col-md-1 col-md-offset-11 col-sm-1 col-sm-offset-2">

                        <a style="width: 100%" href="/{{'addPrivateProject'}}/{{$user->id}}" class="customButton "><i
                                    class="icon-flag"></i> اطلبني</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>