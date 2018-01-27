<?php global $setting;?>
<link rel="stylesheet" href="/front/css/jQuery-plugin-progressbar.css">
@extends('front.__template')
@section('title','الإحصائيات')
@section('content')
@include('front.head_statistic')
    <section class="s_protfolio">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="all_item_profsingle">
                        <div class="heade_div2">
                            <h2>الاحصائيات</h2>
                        </div>
                        <div class="item_user_single">
                            <div class="circ_haq">
                                <i class="icon-folder2"></i>
                                <h2>العروض المقدّمة</h2>
                                <p>{{$user->allbidCount}}</p>
                            </div>
                            <div class="cir_all_item">
                                <div class="col-md-3 col-sm-6">
                                    <h2>بإنتظار الموافقة</h2>
                                    <div class="progress-bar position" data-percent="{{(($user->allbidCount)?$user->newBidCount/$user->allbidCount:0)*100}}" data-color="#e5e6e8,#fe5339">
                                        <h2>{{$user->newBidCount}}</h2>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <h2>قيد التنفيذ</h2>
                                    <div class="progress-bar position" data-percent="{{(($user->allbidCount)?($user->progressBidCount/$user->allbidCount):0)*100}}" data-color="#e5e6e8,#fe5339">
                                        <h2>{{$user->progressBidCount}}</h2>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <h2>المشاريع المكتملة</h2>
                                    <div class="progress-bar position" data-percent="{{(($user->allPCount)?($user->cancelPCount/$user->allPCount):0)*100}}" data-color="#e5e6e8,#fe5339">
                                        <h2>{{$user->cancelPCount}}</h2>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <h2>المشاريع الملغية</h2>
                                    <div class="progress-bar position" data-percent="{{(($user->allPCount)?($user->allPCount/$user->allPCount):0)*100}}" data-color="#e5e6e8,#fe5339">
                                        <h2>{{$user->allPCount}}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                   {{--@include('front.statistic')--}}
                    @include('front.sidePortfolio')
                    @include('front.userSteps')
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script src="/front/js/jQuery-plugin-progressbar.js"></script>
    <script>
        $(".progress-bar").loading();
    </script>
@endsection