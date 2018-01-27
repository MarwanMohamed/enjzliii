<?php global $setting; ?>
<?php global $menu; ?>
<!DOCTYPE html>
<html lang="en">


    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <meta name="description" content="">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <meta name="author" content="">
        <link rel="shortcut icon" href="/panel/images/favicon.png" type="image/png">
        <title>@yield('title')/@yield('subTitle')</title>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link href="/panel/css/prettyPhoto.css" rel="stylesheet">

        <link href="/panel/css/style.default.css" rel="stylesheet">

        <link href="/panel/css/bootstrap-rtl.min.css" rel="stylesheet">
        <link href="/panel/css/bootstrap-override-rtl.css" rel="stylesheet">

        <link href="/panel/css/style.default-rtl.css" rel="stylesheet">
        <link rel="stylesheet" href="/panel/css/bootstrap-timepicker.min.css" />

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="/panel/js/html5shiv.js"></script>
        <script src="/panel/js/respond.min.js"></script>
        <![endif]-->

        <script src="/panel/js/jquery-1.11.1.min.js"></script>
        <style>
          .form-control {
              font-size: 14px;
              height: auto !important;
              padding: 10px;
          }
                select.form-control {
              padding: 6px;
          }
          td a {
              font-size: 14px;
              color: #777;
              text-decoration: none !important;
          }
          .profile-location, .profile-position {
              float: right;
          }.nav-tabs.nav-justified {
            display: inline-block;
          }
          .mb20 ,.mb30{
              width:100%;
              float: right;
          }
          .media-body.act-media-body strong {
    font-size: 18px;
    font-family: 'Droid Arabic Kufi';
    float: right;
    line-height: normal!important;
    width: 100%;
}
          strong {
    font-family: 'Droid Arabic Kufi' !important;
}
          .pageheader h2 span {
    padding-top: 15px;
}
          .media-body.act-media-body p {
    float: right;
    width: 100%;
}
          h5.subtitle {
            float:right;
            width:100%;
    font-size: 14px;
    font-family: 'Droid Arabic Kufi' !important;
}
          input, select, textarea{
            font-family: 'Droid Arabic Kufi' !important;
          }
          .activity-list .act-media:last-child{
            border-bottom:0;
          }
          .media.act-media {
    border-bottom: 1px solid #eee;
    padding-bottom: 15px;
}
          .tab-content{
            box-shadow:none;
          }
          .brief, .address_sub {
    float: right;
    width: 100%;
    font-size: 12px;
}
          h2.profile-name {
    float: right;
    width: 100%;
    color: #444;
    font-size: 18px;
}
          td a.btn.btn-success.pull-right {
    font-size: 12px;
    padding: 5px 8px;
}
          td{
            vertical-align:middle !important;
          }
          td.tdBtn {
    vertical-align: middle !important;
    line-height: 36px !important;
}
          a:hover ,a:focus ,a{
            color:#333;
            text-decoration:none !important;
          }
          .profile-header h2 {
    float: right;
    width: 100%;
    color: #333;
    font-size: 24px;
            margin-bottom:10px;
}
          .profile-header h4 {
    float: right;
    width: 100%;
    color: #333;
    font-size: 18px;
            margin-bottom:10px;
            margin-top:15px;
}
          .profile-header h2 a {
    color: #009688;
    font-size: 22px;
}
          .thumbnail{
            margin-bottom:0;
          }
          h2,h1,h3,h4{
            margin:0;
          }
          .side_conv h4 a {
                color: #009688;
                font-size: 14px !important;
                margin-bottom: 5px !important;
                float: right;
            }
            .side_conv h2 {
                color: #333;
                font-size: 24px;
                margin-bottom: 10px;
            }
          .form-group.cons {
    float: right;
    width: 100%;
    margin-bottom: 10px !important;
    margin-right: 0 !important;
}
        .report a h4 {
    float: right;
    width: 100%;
    font-size: 16px;
    margin: 0;
}
.report a {
    float: right;
    width: 80%;
}
.report img {
    float: right;
    width: 50px;
    height: 50px;
    margin-left: 10px;
}
.report {
    float: right;
    width: 100%;
  margin-bottom:10px;
}  
          
 .report span:last-child {
    float: left;
}

.report span {
    float: right;
    margin: 0 !important;
    font-size: 14px !important;
}
          .title-head{
                float: right;
                width: 98%;
                margin-bottom: 20px;
                border-bottom: 1px solid #efefe1;
                padding-bottom: 7px;
                    font-size: 20px;
                font-weight: bold;
                padding-bottom: 10px;
                margin-right: 10px;
                padding-right:25px;
                  padding-top:20px;
                  padding-bottom:20px;
                background: white;
          }
          
      </style>
    </head>

    <body>
        <style>
            @import url(https://fonts.googleapis.com/earlyaccess/droidarabickufi.css);

            h1,h2,h3,h4,h5,h6,div,tr,td,table,thead th,tr th,.table thead > tr > th,.pageheader,input,.pageheader h2,.logopanel h1{
                font-family: 'Droid Arabic Kufi', serif !important;
            }

            .note{
                color: red;text-align: center;font-size: 20px;
            }
            .date{
                text-align: right;
                direction: ltr;
            }

            input[type=file]::-webkit-file-upload-button {
                visibility: hidden;
            }
            input[type=file]::before {
                content: 'اختر صورة';
                display: inline-block;
                background: -webkit-linear-gradient(top, #f9f9f9, #e3e3e3);
                border: 1px solid #999;
                border-radius: 3px;
                padding: 5px 8px;
                outline: none;
                white-space: nowrap;
                -webkit-user-select: none;
                cursor: pointer;
                text-shadow: 1px 1px #fff;
                font-weight: 700;
                font-size: 10pt;
                color:#868686;
            }
            input[type=file]:hover::before {
                border-color: black;
            }
            input[type=file]:active::before {
                background: -webkit-linear-gradient(top, #e3e3e3, #f9f9f9);
            }
            input[type=file] {
                color:#fff;
            }


            *{
                word-break: break-word;
            }
            .date{
                direction: ltr;
            }
            .attachment{
              float:right;
                width: 100%;
                background-color: #eee;
                min-height: 30px;
                padding: 7px 0px;
                display: inline-flex;
                color: black; 
                margin: 10px 0px;
            }
            .dropdown-list .desc{
                margin-right: 0;
            }
          .profile-location .fa, .profile-position .fa {
    width: 16px;
    margin-left: 8px;
    padding-right: 5px;
    text-align: center;
    padding-top: 5px;
}
             .costum-panel .panel-heading{
                padding: 0;
                height: 200px;
          }
          
          .costum-panel .stat,.costum-panel .stat  .row{
            height:100% ;
            max-width:100%;
            width:100%;
            margin:0;
          }
          .costum-panel .first ,.costum-panel .second{
            height:50%;
            text-align:center;
            padding-top:15px;
          }
          .costum-panel .second{
            background:white;
            color:black;
          }
          
          .panel-stat h1{
                font-size: 26px;
          }
        </style>

        <!-- Preloader -->
        <div id="preloader">
            <div id="status"><i class="fa fa-spinner fa-spin"></i></div>
        </div>

        <section>
            <?php
            ?>
            <div class="leftpanel">

                <div class="logopanel">
                    <h1><span>[</span> {{$setting['siteName']}} <span>]</span></h1>
                </div><!-- logopanel -->

                <div class="leftpanelinner">
                    <!-- This is only visible to small devices -->
                    <div class="visible-xs hidden-sm hidden-md hidden-lg">
                        <div class="media userlogged">
                            <img alt="" src="/panel/images/user.png" class="media-object">
                            <div class="media-body">
                                <h4>مرحبا {{session()->get('admin')->username}}</h4>
                            </div>
                        </div>

                        <h5 class="sidebartitle actitle">الحساب</h5>
                        <ul class="nav nav-pills nav-stacked nav-bracket mb30">
                            <!--<li><a href="/admin/accountSetting"><i class="fa fa-cog"></i> <span>تغير كلمة المرور</span></a></li>-->
                            <li><a href="/admin/logout"><i class="fa fa-sign-out"></i> <span>تسجيل الخروج</span></a></li>
                        </ul>
                    </div>
                    <?php
                    $contoller = request()->segment(2);
                    ?>
                    <h5 class="sidebartitle">القائمة</h5>
                    <ul class="nav nav-pills nav-stacked nav-bracket">
                        
                        <li> <a href="/admin/statistic"><i class="fa fa-bars"></i>الرئيسة</a></li>
                        @foreach($menu as $value)
                        @if(!$value['hasMenu'])
                        <li class='{{$contoller==$value['name_en']?'active in':''}}'><a href="{{$value['url']}}"><i class="{{$value['icon']}}"></i> <span>{{$value['name']}}</span>
                                                    @if(isset($setting[$value['name_en']])&&($setting[$value['name_en']]))<span class="pull-right badge badge-success">{{$setting[$value['name_en']]}}</span>@endif

                            </a></li>
                        @else
                        <li class="nav-parent{{$contoller==$value['name_en']?'nav-active':''}}"><a href=""><i class="{{$value['icon']}}"></i> <span>{{$value['name']}}</span>
                        @if(isset($notifications[$value['name_en']])&&($notifications[$value['name_en']]))
                        <span class="pull-right badge badge-success">@if(isset($notifications[$value['name_en']]) && $notifications[$value['name_en']] > 0)  {{$notifications[$value['name_en']]}} @endif</span>
                        @endif

                            </a>
                            <ul class="children"  {{$contoller==$value['name_en']?'style=display:block':''}} >
                                @foreach($value['fun'] as $function)
                                @if($function['inMenu'])
                                <li class='<?= ($function['id'] == session('function_id')) ? 'active' : '' ?>'><a href="{{$function['url']}}">
                                        @if(isset($notifications[$function['url']])&&($notifications[$function['url']] > 0 ))
                                        <span class="pull-right badge badge-success">
                                          @if(isset($notifications) && $notifications[$function['url']] > 0 ) {{$notifications[$function['url']]}} @endif 
                                        </span>@endif
                                        <i class="fa fa-caret-right "></i>{{$function['name']}} {!!($function['url']=="admin/activateProvider")?"<span class='pull-right badge badge-success ".(($setting["needActivate"])?"":"hidden")." '>".$setting['needActivate']."</span>":''!!}</a></li>
                                @endif
                                @endforeach
                            </ul>
                        </li>
                        @endif
                        @endforeach
                    </ul>

                </div><!-- leftpanelinner -->
            </div><!-- leftpanel -->

            <div class="mainpanel">

                <div class="headerbar">

                    <a class="menutoggle"><i class="fa fa-bars"></i></a>



                    <div class="header-right">
                        <ul class="headermenu">
               


                            <li>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                        <img src="/panel/images/user.png" alt="" />
                                        مرحبا {{session()->get('admin')->username}}
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-usermenu pull-right">
                                        <li><a href="/" target='_blank'><i class="glyphicon glyphicon-home"></i>الموقع</a></li>
                                        <li><a href="/admin/accountSetting"><i class="glyphicon glyphicon-cog"></i>تغير كلمة المرور</a></li>
                                        <li><a href="/admin/logout"><i class="glyphicon glyphicon-log-out"></i> تسجيل الخروج</a></li>
                                    </ul>
                                </div>
                            </li>

                        </ul>
                    </div><!-- header-right -->

                </div><!-- headerbar -->
                <div class="pageheader">
                    <h2><i class="fa fa-home"></i>@yield('title')<span>@yield('subTitle')</span></h2>
                </div>

                <div class="contentpanel">
                  
                            @yield('content')

                     

                </div>
                <div class="modal fade" tabindex="-1" role="dialog" id="ConfirmModal">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header"  style="background-color: #c36865">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">تحذير!!</h4>
                            </div>
                            <div class="modal-body">
                                <p style="font-size: 18px;color: red">هل انت متأكد من العملية. .؟</p>
                            </div>
                            <div class="modal-footer">
                                <a type="button" href="#" class="btn btn-default"  data-dismiss="modal">الغاء</a>
                                <a type="button" class="btn btn-danger" id="complate_delelte">تأكيد</a>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->


        </section>

        <?php $errors = (session('errors')) ? session('errors') : []; ?>

        <script src="/panel/js/jquery-ui-1.10.3.min.js"></script>

        <script src="/panel/js/jquery-migrate-1.2.1.min.js"></script>
        <script src="/panel/js/bootstrap.min.js"></script>
        <script src="/panel/js/modernizr.min.js"></script>
        <script src="/panel/js/jquery.sparkline.min.js"></script>
        <script src="/panel/js/toggles.min.js"></script>
        <script src="/panel/js/retina.min.js"></script>
        <script src="/panel/js/jquery.cookies.js"></script>
        <script src="/panel/js/jquery.validate.min.js"></script>
        <script src="/panel/js/localization/messages_ar.js"></script>
        <script src="/panel/js/select2.min.js"></script>

        <script src="/panel/js/toggles.min.js"></script>

        <script src="/panel/js/noty/jquery.noty.packaged.min.js"></script>

        <script src="/panel/js/custom.js"></script>

        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        @yield('script')
        <script>
$('.Confirm').click(function (e) {
    e.preventDefault();
    $('#ConfirmModal').modal('show');
    $('#complate_delelte').attr('href', $(this).attr('href'));
});
jQuery(document).ready(function () {

    $("#datepicker").datepicker();
})



$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    error: function (xhr, textStatus, errorThrown) {
        switch (xhr.status) {
            case 401:
                // handle unauthorized
                break;
            case 422:
                $.each(xhr.responseJSON, function (key, value) {
                    myNoty(value)
                });
                break;
            default:
                //AjaxError(xhr, textStatus, errorThrown);
                break;
        }
    }
});



@if (count($errors))

var n = noty({
    text: '<div class="alert alert-danger"><p style="text-align: center;"><ul>@foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul></p></div>'
    , layout: 'center', //or left, right, bottom-right... danger
    theme: 'made'
    , maxVisible: 10
    , animation: {
        open: 'animated bounceIn'
        , close: 'animated bounceOut'
    }
    , timeout: 3000
});

@endif

        function myNoty(msg, type = 'danger') {
        var n = noty({
        text: '<div class="alert alert-' + type + '"><p style="text-align: center;">' + msg + '</p></div>'
                , layout: 'center', //or left, right, bottom-right... danger
                theme: 'made'
                , maxVisible: 10
                , animation: {
                open: 'animated bounceIn'
                        , close: 'animated bounceOut'
                }
        , timeout: 3000
        });
        }

$('form').submit(function () {
    $('.form-loader').removeClass('hidden');
});
        </script>
          
          
          
          
          <script>
          
          var numToHu = function (num) {
              if(Math.floor(num/1000000)){
                  return (num/1000000).toFixed(1) +'M';
              }else if(Math.floor(num/1000)){
                  return (num/1000).toFixed(1) +'K';
              }
            return num;
          };
            
            $.fn.digits = function(){ 
              return this.each(function(){ 
                  $(this).text( ($(this).text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")) ); 
              })
          }

            $('.panel-heading h1').each(function(){
              text=$(this).text();
              if(!isNaN(text)){
                    $(this).digits();
              }
            })
          </script>
    </body>
</html>
