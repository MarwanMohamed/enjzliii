<?php global $setting;?>
@extends('front.__template')

@section('title','بيانات الحساب')
@section('subTitle','تعديل')

@section('content')
    @include('front.heade_info')
    <style>
        .selects3 button {
            border-radius: 30px !important;
            background: #fff !important;
            font-size: 12px !important;
            width: 150px !important;
            padding: 8px !important;
            height: 35.8px !important;
            max-width: 100% !important;
        }

        .pad_rig {
            margin-right: 10px;
        }

        .selects3 {
            width: 41%;
        }

        .item_h2s.new-cl-pdd {
            padding: 0 !important;
        }

        .projectsContent {
            margin-top: 10px;;
        }

        .item_x {
            background: #fff;
            padding: 15px;
        }

        .item_x_top {
            background: #fff;
            margin-top: 20px;
        }

        #home p {
            overflow: hidden;
        }

        .item_x {
            background: #fff;
            padding: 0;
        }

        .item_x {
            background: #fff;
            padding: 0;
        }

        .item_x .item_myfas {
            float: right;
            width: 100%;
            padding: 25px 20px;
            border-bottom: solid 1px #efefef;
        }

        .Loader {
            position: absolute;
            z-index: 5;
            right: 75px;
            top: 10px;
        }

        .tabelesa {
            margin: 0;
            padding: 0;
        }

        .tabelesa td {
            text-align: right;
        }

        table.table.table-stripeds tbody td p {
            padding: 0;
            font-size: 16px;
            text-align: right;
            padding-right: 5px;
        }

        table.table.table-stripeds tbody td p i {
            margin-top: 4px;
            position: absolute;
            color: #757575;
            font-size: 16px;
        }

        table.table.table-stripeds tbody td a {
            padding-right: 18px;
        }

        table.table.table-stripeds tbody td span {
            text-align: left;
            padding: 0;
            padding-left: 5px;
        }

        .all_item_profsingle h2 {

            font-size: 16px !important;
            font-weight: 600 !important;

        }

        .all_item_profsingle h2 a {

            color: #fe5339 !important;

        }

        .list_myinfo ul li h2 a {
            font-size: 14px;
            color: #fe5339;
        }
        .noPadding {
            padding: 0 !important;
        }
        @media (min-width: 992px) {

        .goToRight {
            margin-right:125px;
        }
        }
    </style>

    {{--{{dd($tab)}}--}}


    <section class="s_profile">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    @if(session('user')['id']==$user->id)
                        <div class="all_item_prof hdx2s">

                            <div class="list_myinfo">
                                <ul>
                                    <li style="width: 30%;">
                                        <i class="icon-dollar-bills"></i>
                                        <h2><a href="/balance">الرصيد الكلي</a></h2>
                                        <p>${{$user->balance}}</p>
                                    </li>
                                    <li style="width: 30%;">
                                        <i class="icon-euromoneybag"></i>
                                        <h2><a href="/balance">الرصيد المعلق</a></h2>
                                        <p>${{$user->suspended_balance}}</p>
                                    </li>
                                    <li style="width: 30%;">
                                        <i class="icon-wallet"></i>
                                        <h2><a href="/balance">الرصيد المتاح</a></h2>
                                        <p>${{$user->balance-$user->suspended_balance}}</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        {{-- freelancer --}}
                        @if(getUserType($user->type) == 'صاحب مشروع') 
                        <div class="col-sm-12 noPadding">

                            <div id="transactionLoader" class="hidden"></div>
                            <div class="all_item_profsingle">
                                <div class="heade_div2">
                                    <h2><a href="/myProjects">المشاريع ({{$projects_count}})</a></h2>
                                </div>
                                <div class="tabelesa" id="transactionDiv">
                                    <table class="table table-stripeds">
                                        <tbody id="transactionContent">
                                        <tr>
                                            <td>
                                                <p><i class="fa fa-clock-o"></i><a href="/myProjects/1">بانتظار موافقة
                                                        الادارة</a>
                                                </p>
                                            </td>
                                            <td>
                                                <span>{{App\project::fillter(1)->count()}}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p><i class="fa fa-check"></i><a href="/myProjects/2">مفتوح</a></p>
                                            </td>
                                            <td>
                                                <span>{{App\project::fillter(2)->count()}}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p><i class="fa fa-list"></i><a href="/myProjects/6">مكتمل</a></p>
                                            </td>
                                            <td>
                                                <span>{{App\project::fillter(6)->count()}}</span>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <p><i class="fa fa-hourglass"></i><a href="/myProjects/3">قيد
                                                        التنفيذ</a></p>
                                            </td>
                                            <td>
                                                <span>{{App\project::fillter(3)->count()}}</span>
                                            </td>
                                        </tr>


                                        <tr>
                                            <td>
                                                <p><i class="fa fa-reply"></i><a href="/myProjects/4">الملغية</a></p>
                                            </td>
                                            <td>
                                                <span>{{App\project::fillter(4)->count()}}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p><i class="fa fa-close"></i><a href="/myProjects/5">المغلقة</a></p>
                                            </td>
                                            <td>
                                                <span>{{App\project::fillter(5)->count()}}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p><i class="fa fa-ban"></i><a href="/myProjects/7">محظور</a></p>
                                            </td>
                                            <td>
                                                <span>{{App\project::fillter(7)->count()}}</span>
                                            </td>
                                        </tr>   

                                        </tbody>
                                    </table>
                                    <div class="text-center">


                                    </div>
                                </div>
                            </div>

                        </div>
                        {{-- owner --}}
                        @elseif(getUserType($user->type) == 'منجز مشاريع')

                        <div class="col-md-12 col-sm-12 noPadding ">

                            <div id="transactionLoader" class="hidden"></div>
                            <div class="all_item_profsingle">
                                <div class="heade_div2">
                                    <h2><a href="/myBids">العروض ({{$bids_count}})</a></h2>
                                </div>
                                <div class="tabelesa" id="transactionDiv">
                                    <table class="table table-stripeds">
                                        <tbody id="transactionContent">
                                        <tr>
                                            <td>
                                                <p><i class="fa fa-clock-o"></i> <a href="/myBids/1">بانتظار
                                                        الموافقة</a></p>
                                            </td>
                                            <td>
                                                <span>{{$awaitingConfirmationBids}}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p><i class="fa fa-hourglass"></i><a href="/myBids/2">قيد التنفيذ</a>
                                                </p>
                                            </td>
                                            <td>
                                                <span>{{$underway}}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p><i class="fa fa-check"></i><a href="/myBids/3">المكتملة</a></p>
                                            </td>
                                            <td>
                                                <span>{{$complete}}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p><i class="fa fa-reply"></i><a href="/myBids/4">الملغية</a></p>
                                            </td>
                                            <td>
                                                <span>{{$canceled}}</span>
                                            </td>
                                        </tr>


                                        <tr>
                                            <td>
                                                <p><i class="fa fa-close"></i><a href="/myBids/5">المغلقة</a></p>
                                            </td>
                                            <td>
                                                <span>{{$closed}}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p><i class="fa fa-circle"></i><a href="/myBids/6">مستبعدة</a></p>
                                            </td>
                                            <td>
                                                <span>{{$away}}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p><i class="fa fa-ban"></i><a href="/myBids/7">محظور</a></p>
                                            </td>
                                            <td>
                                                <span>{{$blocked}}</span>
                                            </td>
                                        </tr>

                                        </tbody>
                                    </table>
                                    <div class="text-center">


                                    </div>
                                </div>
                            </div>

                        </div>
                        {{-- freelancer and owner --}}
                        @else
                         <div class="col-sm-5 noPadding">

                            <div id="transactionLoader" class="hidden"></div>
                            <div class="all_item_profsingle">
                                <div class="heade_div2">
                                    <h2><a href="/myProjects">المشاريع ({{$projects_count}})</a></h2>
                                </div>
                                <div class="tabelesa" id="transactionDiv">
                                    <table class="table table-stripeds">
                                        <tbody id="transactionContent">
                                        <tr>
                                            <td>
                                                <p><i class="fa fa-clock-o"></i><a href="/myProjects/1">بانتظار موافقة
                                                        الادارة</a>
                                                </p>
                                            </td>
                                            <td>
                                                <span>{{App\project::fillter(1)->count()}}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p><i class="fa fa-check"></i><a href="/myProjects/2">مفتوح</a></p>
                                            </td>
                                            <td>
                                                <span>{{App\project::fillter(2)->count()}}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p><i class="fa fa-list"></i><a href="/myProjects/6">مكتمل</a></p>
                                            </td>
                                            <td>
                                                <span>{{App\project::fillter(6)->count()}}</span>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <p><i class="fa fa-hourglass"></i><a href="/myProjects/3">قيد
                                                        التنفيذ</a></p>
                                            </td>
                                            <td>
                                                <span>{{App\project::fillter(3)->count()}}</span>
                                            </td>
                                        </tr>


                                        <tr>
                                            <td>
                                                <p><i class="fa fa-reply"></i><a href="/myProjects/4">الملغية</a></p>
                                            </td>
                                            <td>
                                                <span>{{App\project::fillter(4)->count()}}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p><i class="fa fa-close"></i><a href="/myProjects/5">المغلقة</a></p>
                                            </td>
                                            <td>
                                                <span>{{App\project::fillter(5)->count()}}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p><i class="fa fa-ban"></i><a href="/myProjects/7">محظور</a></p>
                                            </td>
                                            <td>
                                                <span>{{App\project::fillter(7)->count()}}</span>
                                            </td>
                                        </tr>   

                                        </tbody>
                                    </table>
                                    <div class="text-center">


                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-5 col-sm-12 noPadding goToRight">

                            <div id="transactionLoader" class="hidden"></div>
                            <div class="all_item_profsingle">
                                <div class="heade_div2">
                                    <h2><a href="/myBids">العروض ({{$bids_count}})</a></h2>
                                </div>
                                <div class="tabelesa" id="transactionDiv">
                                    <table class="table table-stripeds">
                                        <tbody id="transactionContent">
                                        <tr>
                                            <td>
                                                <p><i class="fa fa-clock-o"></i> <a href="/myBids/1">بانتظار
                                                        الموافقة</a></p>
                                            </td>
                                            <td>
                                                <span>{{$awaitingConfirmationBids}}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p><i class="fa fa-hourglass"></i><a href="/myBids/2">قيد التنفيذ</a>
                                                </p>
                                            </td>
                                            <td>
                                                <span>{{$underway}}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p><i class="fa fa-check"></i><a href="/myBids/3">المكتملة</a></p>
                                            </td>
                                            <td>
                                                <span>{{$complete}}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p><i class="fa fa-reply"></i><a href="/myBids/4">الملغية</a></p>
                                            </td>
                                            <td>
                                                <span>{{$canceled}}</span>
                                            </td>
                                        </tr>


                                        <tr>
                                            <td>
                                                <p><i class="fa fa-close"></i><a href="/myBids/5">المغلقة</a></p>
                                            </td>
                                            <td>
                                                <span>{{$closed}}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p><i class="fa fa-circle"></i><a href="/myBids/6">مستبعدة</a></p>
                                            </td>
                                            <td>
                                                <span>{{$away}}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p><i class="fa fa-ban"></i><a href="/myBids/7">محظور</a></p>
                                            </td>
                                            <td>
                                                <span>{{$blocked}}</span>
                                            </td>
                                        </tr>

                                        </tbody>
                                    </table>
                                    <div class="text-center">


                                    </div>
                                </div>
                            </div>

                        </div>
                        @endif

                    @else
                        <div class="all_item_profs">
                            <div class="nav_tabsa">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#home">نبذة عني</a></li>
                                    {{--<li><a data-toggle="tab" href="#menu1">{{$user->type==2?'المشاريع':($user->type==1?'العروض':'العروض والمشاريع')}}</a></li>--}}
                                    @if($user->type == 1 || $user->type == 3)
                                        <li><a data-toggle="tab" href="#menu1">العروض</a></li>
                                    @endif
                                    @if($user->type == 2 || $user->type == 3)
                                        <li><a data-toggle="tab" href="#menu2">المشاريع</a></li>
                                    @endif
                                    @if($user->type == 1 || $user->type == 3)
                                        <li><a data-toggle="tab" href="#menu3">التقييمات</a></li>
                                    @endif
                                </ul>
                                <div class="tab-content">
                                    <div id="home" class="tab-pane fade in active">
                                        <?php
                                        $Brief = explode(PHP_EOL, $user->Brief);
                                        foreach ($Brief as $value){
                                        ?>
                                        <p><?=$value?></p>
                                        <?php }if(!$user->Brief){
                                        ?>
                                        <p style="color: #9e9e9e;font-size: 16px;" class='text-center'>لا يوجد نبذة</p>
                                        <?php }?>
                                    </div>
                                    @if($user->type ==1 || $user->type == 3)
                                        <div id="menu1" class="tab-pane fade">
                                            <div class="heade_div2">
                                                <div class="left_item_select {{!sizeof($bids)?'hidden':''}}">

                                                    <div class="selects3">

                                                        <div class="dropdown">
                                                            <button class="btn dropdown-toggle pr10" type="button"
                                                                    data-toggle="dropdown">الاحدث
                                                                <span class="caret"></span></button>
                                                            <ul class="dropdown-menu">
                                                                <li><a href="javascript:;" data-value="0">الاحدث</a>
                                                                </li>
                                                                <li><a href="javascript:;" data-value="1">الاقدم</a>
                                                                </li>
                                                            </ul>
                                                            <i class="fa fa-spin fa-spinner Loader"
                                                               style="display: none;"></i>
                                                            <input type="hidden" value="0" class="drop_sel"
                                                                   name="country_id" id="fillterTime"/>
                                                        </div>
                                                    </div>
                                                    <div class="selects3 pad_rig">

                                                        <div class="dropdown">
                                                            <button class="btn dropdown-toggle pr10" type="button"
                                                                    data-toggle="dropdown">الكل
                                                                <span class="caret"></span></button>
                                                            <ul class="dropdown-menu">
                                                                <li><a href="javascript:;" data-value="0">الكل</a></li>
                                                                <li><a href="javascript:;" data-value="3">مكتمل</a></li>
                                                                <li><a href="javascript:;" data-value="2">قيد
                                                                        التنفيذ</a>
                                                                </li>
                                                                <li><a href="javascript:;" data-value="1">بإنتظار
                                                                        الموافقة</a></li>
                                                                <li><a href="javascript:;" data-value="6">مستبعد</a>
                                                                </li>
                                                                <li><a href="javascript:;" data-value="5">مغلق</a></li>
                                                                <li><a href="javascript:;" data-value="4">ملغى</a></li>
                                                                <li><a href="javascript:;" data-value="7">محظور</a></li>
                                                            </ul>
                                                            <i class="fa fa-spin fa-spinner Loader"
                                                               style="display: none;"></i>

                                                            <input type="hidden" value="0" class="drop_sel"
                                                                   name="country_id" id="fillterType"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item_h2s new-cl-pdd">
                                                <div class="bidsContent">
                                                    @include('front.bids')
                                                </div>

                                            </div>

                                        </div>
                                    @endif
                                    @if($user->type == 2 || $user->type == 3)
                                        <div id="menu2" class="tab-pane fade">
                                            <div class="heade_div2 item_x_top">
                                                <div class="left_item_select {{!sizeof($projects)?'hidden':''}}">
                                                    <div class="selects3">

                                                        <div class="dropdown">
                                                            <button class="btn dropdown-toggle pr10" type="button"
                                                                    data-toggle="dropdown">الاحدث
                                                                <span class="caret"></span></button>
                                                            <ul class="dropdown-menu">
                                                                <li><a href="javascript:;" data-value="0">الاحدث</a>
                                                                </li>
                                                                <li><a href="javascript:;" data-value="1">الاقدم</a>
                                                                </li>
                                                            </ul>
                                                            <i class="fa fa-spin fa-spinner Loader"
                                                               style="display: none"></i>
                                                            <input type="hidden" value="0" class="drop_sel"
                                                                   name="country_id" id="filterTimeProject"/>
                                                        </div>
                                                    </div>
                                                    <div class="selects3 pad_rig">

                                                        <div class="dropdown">
                                                            <button class="btn dropdown-toggle pr10" type="button"
                                                                    data-toggle="dropdown">الكل
                                                                <span class="caret"></span></button>
                                                            <ul class="dropdown-menu">
                                                                <li><a href="javascript:;" data-value="0">الكل</a></li>
                                                                <li><a href="javascript:;" data-value="2">يستقبل
                                                                        عروض</a>
                                                                </li>
                                                                <li><a href="javascript:;" data-value="3">قيد
                                                                        التنفيذ</a>
                                                                </li>
                                                                <li><a href="javascript:;" data-value="6">مكتملة</a>
                                                                </li>
                                                                <li><a href="javascript:;" data-value="5">مغلق</a></li>
                                                                {{--<li><a href="javascript:;" data-value="1">بإنتظار الموافقة</a></li>--}}
                                                                {{--<li><a href="javascript:;" data-value="4">ملغى</a></li>--}}
                                                            </ul>
                                                            <i class="fa fa-spin fa-spinner Loader"
                                                               style="display: none"></i>
                                                            <input type="hidden" value="0" class="drop_sel"
                                                                   name="country_id" id="filterTypeProject"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item_h2s item_x">
                                                <div id="projectsContent">
                                                    @include('front.singleUserProjects')
                                                </div>

                                            </div>

                                        </div>
                                    @endif
                                    @if($user->type == 1 || $user->type == 3)
                                        <div id="menu3" class="tab-pane fade">

                                            @if($evaluates->count()>0)
                                                <div class="divt_rate">
                                                    <div class="first_rate">
                                                        <h2>الإحترافية بالتعامل</h2>
                                                        <ul>
                                                            @for($i=0 ;$i<5;$i++)
                                                                <li class="{{($i<$user->ProfessionalAtWork)?'active':''}}">
                                                                    <i
                                                                            class="icon-star"></i></li>
                                                            @endfor
                                                        </ul>
                                                    </div>
                                                    <div class="first_rate">
                                                        <h2>التواصل والمتابعة</h2>
                                                        <ul>
                                                            @for($i=0 ;$i<5;$i++)
                                                                <li class="{{($i<$user->CommunicationAndMonitoring)?'active':''}}">
                                                                    <i class="icon-star"></i></li>
                                                            @endfor
                                                        </ul>
                                                    </div>
                                                    <div class="first_rate">
                                                        <h2>جودة العمل المسلّم </h2>
                                                        <ul>
                                                            @for($i=0 ;$i<5;$i++)
                                                                <li class="{{($i<$user->quality)?'active':''}}"><i
                                                                            class="icon-star"></i></li>
                                                            @endfor
                                                        </ul>
                                                    </div>
                                                    <div class="first_rate">
                                                        <h2>الخبرة بمجال المشروع </h2>
                                                        <ul>
                                                            @for($i=0 ;$i<5;$i++)
                                                                <li class="{{($i<$user->experience)?'active':''}}"><i
                                                                            class="icon-star"></i></li>
                                                            @endfor
                                                        </ul>
                                                    </div>
                                                    <div class="first_rate">
                                                        <h2>التعامل معه مرّة أخرى </h2>
                                                        <ul>
                                                            @for($i=0 ;$i<5;$i++)
                                                                <li class="{{($i<$user->workAgain)?'active':''}}"><i
                                                                            class="icon-star"></i></li>
                                                            @endfor
                                                        </ul>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="scand_rate">
                                                {{--                                        {{dd($evaluates->count())}}--}}
                                                @if($evaluates->count()>0)
                                                    <div class="heade_div2">
                                                        <h2>أراء العملاء</h2>
                                                        <div class="left_item_select">

                                                            <div class="selects4" style="width:130PX">

                                                                <div class="dropdown">
                                                                    <button class="btn dropdown-toggle" type="button"
                                                                            data-toggle="dropdown">الاحدث
                                                                        <span class="caret"></span></button>
                                                                    <ul class="dropdown-menu">
                                                                        <li><a href="javascript:;"
                                                                               data-value="0">الاحدث</a>
                                                                        </li>
                                                                        <li><a href="javascript:;"
                                                                               data-value="1">الاقدم</a>
                                                                        </li>
                                                                    </ul>
                                                                    <i class="fa fa-spin fa-spinner Loader"
                                                                       style="display: none"></i>
                                                                    <input type="hidden" value="0" class="drop_sel"
                                                                           name="country_id" id="evaluteOrder"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="evaluateContent">
                                                        @include('front.evaluates')
                                                    </div>
                                                @else
                                                    <p style="padding: 20px; color: #9e9e9e" class='text-center'>لم يتم تقيمه بعد</p>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                        </div>
                    @endif
                </div>
                <div class="col-md-4">
                    @if(session('user')['id']==$user->id)
                        {{--<div class="all_item_prof hdx3">--}}
                        {{--<div class="heade_div2">--}}
                        {{--</div>--}}

                        {{--<div class="left_side_protfolio ">--}}
                        {{--<ul class="list_profile">--}}
                        {{--<li>--}}
                        {{--<i class="icon-folder2"></i>--}}
                        {{--<h2>كل العروض</h2>--}}
                        {{--<p>{{$bids_count}}</p>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                        {{--<i class="icon-clock"></i>--}}
                        {{--<h2>يانتظار الموافقة</h2>--}}

                        {{--<p>{{$awaitingConfirmationBids}}</p>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                        {{--<i class="icon-runer-silhouette-running-fast"></i>--}}
                        {{--<h2>قيد التنفيذ</h2>--}}
                        {{--<p>{{$underway}}</p>--}}
                        {{--</li>--}}

                        {{--<li>--}}
                        {{--<i class="icon-loadingprocess"></i>--}}
                        {{--<h2>مكتملة</h2>--}}
                        {{--<p>{{$complete}}</p>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                        {{--<i class="icon-alarm-clock"></i>--}}
                        {{--<h2>مستبعدة</h2>--}}
                        {{--<p>{{$canceled}}</p>--}}
                        {{--</li>--}}


                        {{--</ul>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--@include('front.sideBalance')--}}
                    @endif
                    @include('front.sidePortfolio')
                    @include('front.sideSkills')
                </div>
            </div>
        </div>
    </section>

    <section class="get_some_error3">
        <div class="bg_get_some_error3"></div>
        <div class="get_some_error_item3">
            <div class="heade_div2">
                <h2>تغعيل هاتفك</h2>
                <button class="close_get_some3"><img src="images/Close2Icon.png"></button>
            </div>
            <div class="item_get_some2 hige_pad">
                <h2>كود التفعيل<span>*</span></h2>
                <input type="text" name="" placeholder="active phone number">
                <button class="phone_buttn">تفعيل</button>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>

        $(document).ready(function(){
            var value = readCookie('tabName');
            var tab = $("[href="+value+"]").trigger('click');
        });
 
        function readCookie(name) {
            var nameEQ = name + "=";
            var ca = document.cookie.split(';');
            for(var i=0;i < ca.length;i++) {
                var c = ca[i];
                while (c.charAt(0)==' ') c = c.substring(1,c.length);
                if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
            }
            return null;
        }

        $('body').on('click', 'li a', function (e) {
            var cookie = document.cookie = "tabName=" + $(this).attr('href');
        });



        $('body').on('click', '.bidsPage .pagination a', function (e) {
            e.preventDefault();
            $(this).html('<i class="fa fa-spin fa-spinner"></i>');
            getBids($(this).attr('href').split('page=')[1], $(this));
        });
        $('body').on('click', '.evaluatePage .pagination a', function (e) {
            e.preventDefault();
            $(this).html('<i class="fa fa-spin fa-spinner"></i>');

            getEvaluate($(this).attr('href').split('page=')[1], $(this));
        });

        $('body').on('change', '#evaluteOrder', function () {
            evaluteOrder = $(this).val();
            Loader = $(this).siblings('.Loader');
            getEvaluate();
        });

        fillterTime = 0;
        evaluteOrder = 0;
        fillterType = 0;
        Loader = '';
        $('body').on('change', '#fillterTime', function () {
            fillterTime = $(this).val();
            Loader = $(this).siblings('.Loader');
            getBids();
        });


        $('body').on('change', '#fillterType', function () {
            fillterType = $(this).val();
            Loader = $(this).siblings('.Loader');
            getBids();
        });
        var getBidsAjax = false;
        function getBids(page=1) {
            if (!getBidsAjax) {
                getBidsAjax = true;
                if (Loader) {
                    Loader.show();
                }
                $.ajax({
                    url: '/getBids?id=<?=$user->id?>&page=' + page,
                    data: {fillterTime: fillterTime, fillterType: fillterType, type: 'bids'},
                    dataType: 'json',
                }).done(function (data) {
                    $('.bidsContent').html(data.view);
                    getBidsAjax = false;
                }).fail(function () {
                    nofication_error('حصل خطأ ما');
                    getBidsAjax = false;
                }).complete(function () {
                    if (Loader)
                        Loader.hide();
                });
            }
        }

        //////////////////////////////////////////////////
        filterTimeProject = 0;
        filterTypeProject = 0;
        loaderPoject = '';
        $('body').on('change', '#filterTimeProject', function () {
            filterTimeProject = $(this).val();
            loaderPoject = $(this).siblings('.Loader');
            getProjects();
        });


        $('body').on('change', '#filterTypeProject', function () {
            filterTypeProject = $(this).val();
            loaderPoject = $(this).siblings('.Loader');
            getProjects();
        });
        var getProjectsAjax = false;

        var getUrlParameter = function getUrlParameter(sParam, url) {
            var sPageURL = decodeURIComponent(window.location.search.substring(1)),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;

            for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');

                if (sParameterName[0] === sParam) {
                    return sParameterName[1] === undefined ? true : sParameterName[1];
                }
            }
        };


        $('body').on('click', '.pagination a', function (e) {
            e.preventDefault();

            var url_string = $(this).attr('href');
            var url = new URL(url_string);
            var page = url.searchParams.get("page");
            getProjects(page);
        });

        function getProjects(page=1) {
            if (!getProjectsAjax) {
                getProjectsAjax = true;
                if (loaderPoject) {
                    loaderPoject.show();
                }
                $.ajax({
                    url: '/getBids?id=<?=$user->id?>&page=' + page,
                    data: {fillterTime: filterTimeProject, fillterType: filterTypeProject, type: 'project'},
                    dataType: 'json'
                }).done(function (data) {
                    $('#projectsContent').html(data.view);
                    location.hash = page;
                    getProjectsAjax = false;
                }).fail(function () {
                    nofication_error('حصل خطأ ما');
                    getProjectsAjax = false;
                }).complete(function () {
                    if (loaderPoject)
                        loaderPoject.hide();
                });
            }
        }


        var getEvaluateAjax = false;

        function getEvaluate(page=1) {
            if (!getBidsAjax) {
                getBidsAjax = true;
                Loader.show();

                $.ajax({
                    url: '/getEvaluate?id=<?=$user->id?>&page=' + page,
                    data: {evaluteOrder: evaluteOrder},

                    dataType: 'json',
                }).done(function (data) {
                    $('.evaluateContent').html(data.view);
                    getEvaluateAjax = false;
                }).fail(function () {
                    alert('Posts could not be loaded.');
                    getEvaluateAjax = false;
                }).complete(function () {
                    Loader.hide();
                });
            }
        }
    </script>
@endsection