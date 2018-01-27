<!--/**-->
<!-- * Created by PhpStorm.-->
<!-- * User: abedmq-->
<!-- * Date: 4/10/2017-->
<!-- * Time: 3:40 PM-->
<!-- */-->

@extends('admin._layout')
<?php global $setting;?>

@section('title','حسابات المستخدمين')
@section('subTitle','عرض المستخدم')

@section('content')

    <style>
        .activity-list .act-thumb{
            width: 128px;
        }
    </style>


    <div class="contentpanel">

        <div class="row">
            <div class="col-sm-3">
                <img src="{{$user->avatar()}}" class="thumbnail img-responsive" alt=""/>

                <div class="mb30"></div>

                <h5 class="subtitle">عن المستخدم</h5>
                <p class="brief">{{str_limit($user->Brief,500)}}</p>

                <div class="mb30"></div>

                <h5 class="subtitle">بيانات المستخدم</h5>
                <address class='address_sub'>
                    <span>اسم المستخدم :</span>{{$user->username?$user->username:'غير مدخل'}}<br>
                    <span>البريد الإلكتروني :</span> {{$user->email}} <br>
                    <span>الملف الشخصي :</span> {{$user->isFinishProfile?'جاهز':'غير جاهز'}} <br>

                </address>

            </div><!-- col-sm-3 -->
            <div class="col-sm-9">

                <div class="profile-header">
                    <h2 class="profile-name">{{$user->fullname()}}</h2>
                    <div class="profile-location"><i class="fa fa-map-marker"></i>{{($user->country)?$user->country->name:'غير مدخل'}}</div>
                    <div class="profile-position"><i class="fa fa-briefcase"></i> {{$user->city?$user->city:'غير مدخل' }}</div>

                    <div class="mb20"></div>

                    <button class="btn btn-success mr5 hidden"><i class="fa fa-user"></i> Follow</button>
                    <button class="btn btn-white hidden"><i class="fa fa-envelope-o"></i> Message</button>
                </div><!-- profile-header -->

                <!-- Nav tabs -->
                <ul class="nav nav-tabs nav-justified nav-profile">
                    @if($user->type == 1 || $user->type == 3)
                    <li><a href="#bids" data-toggle="tab"><strong>العروض</strong></a></li>
                    @endif
                    @if($user->type == 2 || $user->type == 3)
                    <li><a href="#projects" data-toggle="tab"><strong>المشاريع</strong></a></li>
                    @if($user->type == 1 || $user->type == 3)
                    <li><a href="#portfolio" data-toggle="tab"><strong>الأعمال</strong></a></li>
                    @endif
                    <li><a href="#evaluates" data-toggle="tab"><strong>التقيمات</strong></a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    @if($user->type == 1 || $user->type == 3)
                    <div class="tab-pane" id="bids">
                        <div class="activity-list">
                                @foreach($user->bids as $bid)

                            <div class="media act-media">
                                    <div class="media-body act-media-body" >
                                        <strong>{{$bid->project->title}}</strong></strong>
                                        <p>{{$bid->letter}}</p>
                                        <p>
                                            <sapn style="margin-left: 15px;">{{$bid->cost.' $'}}</sapn>
                                            <span  style="margin-left: 15px;">{{$bid->deliveryDuration.' يوم'}}</span>
                                              <small class="text-muted">{{$bid->created_at}}</small>

                                        </p>

                                  </div>
                                      </div><!-- media -->

                                @endforeach
                                @if(!sizeof($user->bids))
                                    <div><span>لا يوجد عروض</span></div>
                                @endif
                        </div><!-- activity-list -->


                    </div>
                    @endif
                    @if($user->type == 2 || $user->type == 3)
                    <div class="tab-pane" id="projects">

                            @foreach($user->myProjects as $project)
                                <div class="media" >
                                    <a class="pull-left hidden" href="#">
                                        <img class="media-object" src="holder.js/100x125" alt=""/>
                                    </a>
                                    <div class="media-body">
                                        <h3 class="follower-name">{{$project->title}}</h3>
                                        <div class="profile-location">{{str_limit($project->description,500)}}</div>
                                        <div class="profile-position">{{$project->budget->fBudget()}}</div>
                                        <div class="profile-position"><i class="fa fa-clock-o"></i>{{$project->deliveryDuration.' يوم'}}</div>

                                        <div class="mb20"></div>


                                    </div>
                                </div><!-- media -->
                            @endforeach
                                @if(!sizeof($user->myProjects))
                                    <div><span>لا يوجد مشاريع</span></div>
                                @endif


                    </div>
                    @endif
                    @if($user->type == 1 || $user->type == 3)
                    <div class="tab-pane" id="portfolio">

                        <div class="activity-list">
                            @foreach($user->portfolios as $portfolio)
                            <div class="media act-media">
                                <a class="pull-left" href="javascript:;">
                                    <img class="media-object act-thumb" src="/image/250x250/{{$portfolio->Thumbnail}}" alt=""/>
                                </a>
                                <div class="media-body act-media-body">
                                    <strong>{{str_limit($portfolio->title,500)}}</strong><br/>
                                    <strong>{{str_limit($portfolio->description,500)}}</strong><br/>
                                    <small class="text-muted">{{$portfolio->created_at}}</small>

                                </div>
                            </div><!-- media -->
                            @endforeach
                        </div><!-- activity-list -->
                        @if(!sizeof($user->portfolios))
                            <div><span>لا يوجد أعمال</span></div>
                        @endif

                    </div>
                    @endif
                    <div class="tab-pane" id="evaluates">
                        @include('admin.users.evaluate')
                    </div>
                </div><!-- tab-content -->

            </div><!-- col-sm-9 -->
        </div><!-- row -->

    </div><!-- contentpanel -->



@endsection
@section('script')
    <script>
        $(function(){
           $('.tab-content .tab-pane:first, .nav.nav-tabs li:first').addClass('active') 
        });
    </script>
@endsection