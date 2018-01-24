@extends('admin._layout2')
<?php global $setting; ?>

@section('title','احصائيات')
@section('subTitle','عرض')

@section('content')
    @if(session()->has('msg'))
        <div class="form-group">
            <div class="alert alert-info">{{session()->get('msg')}}</div>
        </div>
    @endif

    <style>
        th a {
            width: 100%;
            height: 100%;
            color: #000;
            display: block;
            font-size: 16px;
        }
    </style>

    <div class="row">


        <div class="col-sm-6 col-md-3">
            <div class="panel panel-success panel-stat costum-panel">
                <div class="panel-heading">

                    <div class="stat">
                        <div class="row">
                            <div class="col-xs-12 first">
                                <img src="/panel/images/is-user.png" alt=""/>
                            </div>
                            <div class="col-xs-12 second">
                                <small class="stat-label">عدد المستخدمين</small>
                                <h1>{{$users}}</h1>
                            </div>
                        </div><!-- row -->


                    </div><!-- stat -->

                </div><!-- panel-heading -->
            </div><!-- panel -->
        </div><!-- col-sm-6 -->


        <div class="col-sm-6 col-md-3">
            <div class="panel panel-primary panel-stat costum-panel">
                <div class="panel-heading">

                    <div class="stat">
                        <div class="row">
                            <div class="col-xs-12 first">
                                <img src="/panel/images/is-document.png" alt=""/>
                            </div>
                            <div class="col-xs-12 second">
                                <small class="stat-label">عدد المشاريع</small>
                                <h1>{{$project}}</h1>
                            </div>
                        </div><!-- row -->


                    </div><!-- stat -->

                </div><!-- panel-heading -->
            </div><!-- panel -->
        </div><!-- col-sm-6 -->


        <div class="col-sm-6 col-md-3">
            <div class="panel panel-info panel-stat costum-panel">
                <div class="panel-heading">

                    <div class="stat">
                        <div class="row">
                            <div class="col-xs-12 first">
                                <img src="/panel/images/is-document.png" alt=""/>
                            </div>
                            <div class="col-xs-12 second">
                                <small class="stat-label">عدد العروض</small>
                                <h1>{{$bid}}</h1>
                            </div>
                        </div><!-- row -->


                    </div><!-- stat -->

                </div><!-- panel-heading -->
            </div><!-- panel -->
        </div><!-- col-sm-6 -->


        <div class="col-sm-6 col-md-3">
            <div class="panel panel-dark panel-stat costum-panel">
                <div class="panel-heading">

                    <div class="stat">
                        <div class="row">
                            <div class="col-xs-12 first">
                                <img src="/panel/images/is-user.png" alt=""/>
                            </div>
                            <div class="col-xs-12 second">
                                <small class="stat-label">عدد المحادثات</small>
                                <h1>{{$conversation}}</h1>
                            </div>
                        </div><!-- row -->


                    </div><!-- row -->

                </div><!-- stat -->

            </div><!-- panel-heading -->
        </div><!-- panel -->




        <div class="col-sm-6 col-md-3">
            <div class="panel panel-primary panel-stat costum-panel">
                <div class="panel-heading">

                    <div class="stat">
                        <div class="row">
                            <div class="col-xs-12 first">
                                <img src="/panel/images/is-document.png" alt=""/>
                            </div>
                            <div class="col-xs-12 second">
                                <small class="stat-label">عدد التبليغات</small>
                                <h1>{{$reports}}</h1>
                            </div>
                        </div><!-- row -->


                    </div><!-- stat -->

                </div><!-- panel-heading -->
            </div><!-- panel -->
        </div><!-- col-sm-6 -->


        <div class="col-sm-6 col-md-3">
            <div class="panel panel-info panel-stat costum-panel">
                <div class="panel-heading">

                    <div class="stat">
                        <div class="row">
                            <div class="col-xs-12 first">
                                <img src="/panel/images/is-document.png" alt=""/>
                            </div>
                            <div class="col-xs-12 second">
                                <small class="stat-label">عدد الأعمال</small>
                                <h1>{{$portfolio}}</h1>
                            </div>
                        </div><!-- row -->


                    </div><!-- stat -->

                </div><!-- panel-heading -->
            </div><!-- panel -->
        </div><!-- col-sm-6 -->


        <div class="col-sm-6 col-md-3">
            <div class="panel panel-dark panel-stat costum-panel">
                <div class="panel-heading">

                    <div class="stat">
                        <div class="row">
                            <div class="col-xs-12 first">
                                <img src="/panel/images/is-document.png" alt=""/>
                            </div>
                            <div class="col-xs-12 second">
                                <small class="stat-label">عدد المشاريع السوبر</small>
                                <h1>{{$vipProjects}}</h1>
                            </div>
                        </div><!-- row -->


                    </div><!-- row -->

                </div><!-- stat -->

            </div><!-- panel-heading -->
        </div><!-- panel -->
        <div class="col-sm-6 col-md-3">
            <div class="panel panel-dark panel-stat costum-panel">
                <div class="panel-heading">

                    <div class="stat">
                        <div class="row">
                            <div class="col-xs-12 first">
                                <img src="/panel/images/is-document.png" alt=""/>
                            </div>
                            <div class="col-xs-12 second">
                                <small class="stat-label">عدد المعاملات المالية</small>
                                <h1>{{$transactions}}</h1>
                            </div>
                        </div><!-- row -->


                    </div><!-- row -->

                </div><!-- stat -->

            </div><!-- panel-heading -->
        </div><!-- panel -->
    </div>




@endsection
