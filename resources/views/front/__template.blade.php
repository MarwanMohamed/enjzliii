<!doctype html>
<html lang="ar" class="no-js">
<?php global $templateData; ?>
<?php global $setting; ?>
<head>
    <title>@yield('title')</title>
    @include('front/template_header')
    <link rel="shortcut icon" type="image/ico" href="/front/images/favicon.ico"/>
    <link rel="stylesheet" href="/front/css/bootstrap.min.css">
    <link rel="stylesheet" href="/front/css/bootstrap-rtl.css">
    <link rel="stylesheet" href="/front/css/ion.rangeSlider.css"/>
    <link rel="stylesheet" href="/front/css/ion.rangeSlider.skinHTML5.css"/>
    <link rel="stylesheet" href="/front/css/font-style.css">
    <link rel='stylesheet' href='/front/css/select2.min.css'>
    <link rel="stylesheet" href="https://rawgit.com/enyo/dropzone/master/dist/dropzone.css">
    <link rel="stylesheet" href="/front/css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="/front/font/flaticon.css">
    <script src="/front/js/jquery.min.js"></script>
    @yield('styles')
    <style>
        label.error {
            position: absolute;
            left: 0;
            width: initial;
            padding: 10px;
            color: red;
        }

        input.error {
            border-color: red;
        }

        .dropzone .dz-preview .dz-image img {
            display: block;
            margin: auto;
        }

        input.dz-hidden-input {
            display: none;
        }

        .dropzone .dz-preview.dz-image-preview {
            width: 170px !important;
            height: 130px !important;
        }

        .dropzone .dz-preview .dz-image img {

            height: auto;
            width: auto;
            border-radius: 0px;
        }

        .img_addqw ul {
            border: none;
        }

        .drop {
            border: 3px dashed #f3f4f5 !important;
        }

        .dropzone .dz-preview .dz-image {
            height: 100% !important;
            width: 100% !important;
            border-radius: 0px !important;
            z-index: 0 !important;
        }

        .dropdown-menu-width {
            width: 100% !important;
        }

        .dropzone .dz-preview.dz-file-preview .dz-image {

            height: 130px !important;
        }

        .dropzone .dz-preview .dz-error-message {

            top: 20px !important;
            left: 13px !important;
        }

        .dropzone {
            min-height: 0 !important;
        }

        #editLoader {
            left: 0 !important;

        }

        ul.ino_user_list.list-menu-avatar i {
            color: #939393;
            margin-left: -10px;
            margin-top: -2px;
        }

        ul.ino_user_list.list-menu-avatar p {
            margin-top: 6px;
        }
    </style>
</head>
<body class="body">
<div class="menu_sidebar">
    <ul class="menu-sidebar">
        @if(!session('user'))
            <li class=" menu-responseve"><a href="{{session('user')?'/singleUser':'/'}}">
                    الرئيسة</a></li>
        @endif
        <li class=" menu-responseve"><a href="/projects"> المشاريع</a></li>
        @if(session('user'))
            @if(session('user')['type'] !=1)
                <li class=" menu-responseve"><a href="/addProject"> اضف مشروع</a></li>
            @endif
        @endif
        @if(session('user'))
            @if(session('user')['isVIP'] || session('user')['type'] !=1)
                <li class=" menu-responseve"><a href="/freelancerSearch"> ابحث عن منجز</a></li>
            @endif
        @endif
        @if(session('user'))
            @if(!session('user')['isVIP']  && session('user')['type'] !=2)

                <li class="active"><a><i class="icon-file"></i> عروضي</a>
                    <ul class="ino_user_list">
                        <li>
                            <a href="/myBids">
                                <div class="text_useinfo">
                                    <h2><i class="icon-user1"></i>الكل</h2>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="/myBids/1">
                                <div class="text_useinfo">
                                    <h2><i class="icon-star"></i>بإنتظار الموافقة</h2>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="/myBids/2">
                                <div class="text_useinfo">
                                    <h2><i class="icon-moneybag"></i>قيد التنفيذ</h2>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="/myBids/3">
                                <div class="text_useinfo">
                                    <h2><i class="icon-folder2"></i>مكتملة</h2>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="/myBids/6">
                                <div class="text_useinfo">
                                    <h2><i class="icon-folder2"></i>مستبعدة</h2>
                                </div>
                            </a>
                        </li>

                    </ul>
                </li>
            @endif
            @if(session('user')['type'] !=1)


                <li class="active"><a><i class="icon-file"></i> مشاريعي</a>
                    <ul class="ino_user_list">
                        <li>
                            <a href="/myProjects">
                                <div class="text_useinfo">
                                    <h2><i class="icon-user1"></i>الكل</h2>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="/myProjects/2">
                                <div class="text_useinfo">
                                    <h2><i class="icon-star"></i>يستقبل عروض</h2>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="/myProjects/3">
                                <div class="text_useinfo">
                                    <h2><i class="icon-moneybag"></i>قيد التنفيذ</h2>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="/myProjects/6">
                                <div class="text_useinfo">
                                    <h2><i class="icon-folder2"></i>المكتملة</h2>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="/myProjects/5">
                                <div class="text_useinfo">
                                    <h2><i class="icon-folder2"></i>المغلقة</h2>
                                </div>
                            </a>
                        </li>

                    </ul>
                </li>
            @endif

        @else
            <li><a href="/" class="list_ascka">الرئيسية</a></li>
            <li><a><i class="icon-user1"></i> المستخدم</a>
                <ul>
                    <li><a href="/register" class="a_bord">حساب جديد</a></li>
                    <li><a href="/login">دخول</a></li>
                </ul>
            </li>
        @endif
    </ul>
</div>
<div class="body_bg"></div>
<section class="headerl">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-sm-12 col-xs-12 pull-right navigation">
                <nav class="navbar navbar-default">
                    <div class="container-fluid">
                        <div class="logo-img">
                            <span class="btnmenu"><i class="icon-menu-options"></i></span>
                            <a href="{{session('user')?'/singleUser/'.session('user')['id']:'/'}}"><h2>انجزلي</h2></a>
                            @if(session('user'))
                                <ul class="head-menu5 nav navbar-nav avbar-left">
                                    <li class="message">
                                        @include('front.message')
                                    </li>
                                    <li class="notifaction">
                                        @include('front.notifcation')
                                    </li>
                                    <li>
                                        <div class="prof">
                                            <?php global   $setting?>
                                            <img class='avatarImage'
                                                 src="{{avatar(session('user')['avatar'],$setting)}}">
                                        </div>
                                        <ul class="ino_user_list list-menu-avatar">
                                            <li>
                                                <a href="/singleUser">
                                                    <i class="flaticon-user"></i>
                                                    <p>الملف الشخصي</p>
                                                </a>
                                            </li>
                                            @if(session('user')['type'] !=2)
                                                <li>
                                                    <a href="/portfolios">
                                                        <i class="flaticon-briefcase"></i>
                                                        <p>أعمالي</p>
                                                    </a>
                                                </li>
                                            @endif
                                            <li>
                                                <a href="/myFavorite">
                                                    <i class="flaticon-bookmark"></i>
                                                    <p>المفضلة الشخصية</p>
                                                </a>
                                            </li>
                                            @if(!session('user')['isVIP'])
                                                <li>
                                                    <a href="/balance">
                                                        <i class="flaticon-dollar-symbol"></i>
                                                        <p>الرصيد</p>
                                                    </a>
                                                </li>
                                            @endif
                                            @if(session('user')['type'] !=1)
                                                <li>
                                                    <a href="/myProjects">
                                                        <i class="flaticon-folder-1"></i>
                                                        <p>مشاريعي</p>
                                                    </a>
                                                </li>
                                            @endif
                                            @if(!session('user')['isVIP'] && session('user')['type']!=2)

                                                <li>
                                                    <a href="/myBids">
                                                        <i class="flaticon-choices"></i>
                                                        <p>عروضي</p>
                                                    </a>
                                                </li>
                                            @endif
                                            <li>
                                                <a href="/editProfile">
                                                    <i class="flaticon-briefcase"></i>
                                                    <p>تعديل الملف الشخصي</p>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="/notifcationSetting">
                                                    <i class="flaticon-alarm"></i>
                                                    <p>اعدادات التنبيهات</p>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="/logout">
                                                    <i class="flaticon-logout"></i>
                                                    <p>تسجيل الخروج</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>

                            @endif
                        </div>
                        <div class="collapse navbar-collapse" id="defaultNavbar1">
                            <?php $segment = request()->segment(1) ?>
                            <ul class="head-menu3 nav navbar-nav avbar-right">
                                @if(!session('user'))
                                    <li><a href="/" class="{{(!$segment)?'active':''}}">الرئيسية</a></li>
                                @endif
                                @if(session('user'))
                                    @if(session('user')['type']!=1)
                                        <li><a href="/addProject" class="{{($segment=='addProject')?'active':''}}">أضف
                                                مشروع</a></li>
                                    @endif
                                    @if(!session('user')['isVIP'] && session('user')['type'] !=1)
                                        <li><a href="/freelancerSearch"
                                               class="{{($segment=='freelancers')?'active':''}}">أبحث عن منجز</a></li>
                                    @endif
                                @endif
                                <li><a href="/projects" class="{{($segment=='projects')?'active':''}}">المشاريع</a></li>
                            </ul>
                        </div><!-- /.navbar-collapse -->
                    </div><!-- /.container-fluid -->
                </nav>
            </div>
            @if(session('user'))
                <div class="col-md-4 pull-left navigation">
                    <nav class="navbar navbar-default">
                        <div class="container-fluid">
                            <div class="collapse navbar-collapse" id="defaultNavbar1">
                                <ul class="head-menu5 nav navbar-nav avbar-left">
                                    <li class="message">
                                        @include('front.message')
                                    </li>
                                    <li class="notifaction">
                                        @include('front.notifcation')
                                    </li>
                                    <li>
                                        <div class="prof">
                                            <?php global  $setting?>
                                            <a href="/singleUser">
                                                <img class='avatarImage'
                                                     src="{{avatar(session('user')['avatar'],$setting)}}">
                                                <h2 class='fullname'>
                                                    أهلاً، {{str_limit(session('user')['fname'],5)}}</h2>
                                            </a>
                                        </div>
                                        <ul class="ino_user_list list-menu-avatar">
                                            <li>
                                                <a href="/singleUser">
                                                    <i class="flaticon-user"></i>
                                                    <p>الملف الشخصي</p>
                                                </a>
                                            </li>
                                            @if(session('user')['type']!=2)

                                                <li>
                                                    <a href="/portfolios">
                                                        <i class="flaticon-briefcase"></i>
                                                        <p>أعمالي</p>
                                                    </a>
                                                </li>
                                            @endif
                                            <li>
                                                <a href="/myFavorite">
                                                    <i class="flaticon-bookmark"></i>
                                                    <p>المفضلة الشخصية</p>
                                                </a>
                                            </li>
                                            @if(!session('user')['isVIP'])
                                                <li>
                                                    <a href="/balance">
                                                        <i class="flaticon-dollar-symbol"></i>
                                                        <p>الرصيد</p>
                                                    </a>
                                                </li>
                                            @endif
                                            @if(session('user')['type']!=1)

                                                <li>
                                                    <a href="/myProjects">
                                                        <i class="flaticon-folder-1"></i>
                                                        <p>مشاريعي</p>
                                                    </a>
                                                </li>
                                            @endif
                                            @if(!session('user')['isVIP'] &&(session('user')['type']!=2))
                                                <li>
                                                    <a href="/myBids">
                                                        <i class="flaticon-choices"></i>
                                                        <p>عروضي</p>
                                                    </a>
                                                </li>
                                            @endif
                                            <li>
                                                <a href="/editProfile">
                                                    <i class="flaticon-user"></i>
                                                    <p>تعديل الملف الشخصي</p>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="/notifcationSetting">
                                                    <i class="flaticon-alarm"></i>
                                                    <p>اعدادات التنبيهات</p>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="/logout">
                                                    <i class="flaticon-logout"></i>
                                                    <p>تسجيل الخروج</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>
            @else
                <div class="col-md-3 hidden-sm hidden-xs pull-left navigation">
                    <nav class="navbar navbar-default">
                        <div class="container-fluid">
                            <div class="collapse navbar-collapse" id="defaultNavbar1">
                                <ul class="head-menu4 nav navbar-nav avbar-left">
                                    <li><a href="/register" class="a_bord">حساب جديد</a></li>
                                    <li><a href="/login">دخول</a></li>
                                </ul>
                            </div><!-- /.navbar-collapse -->
                        </div><!-- /.container-fluid -->
                    </nav>
                </div>
            @endif
        </div>
    </div>
</section>
@yield('content')
@include('front/template_footer')
<div class="modal fade" tabindex="-1" id="confirmModal1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="confirmTitle"></h4>
            </div>
            <div class="modal-body">
                <p id="confirmSubject"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">الغاء</button>
                <a type="button" id="confirmUrl" class="btn btn-danger">موافق</a>
            </div>
        </div>
    </div>
</div>
<section class="nofication_good">
    <div class="bg_nofication"></div>
    <div class="nofication_good_item">
        <button class="close_good"><i class="icon-delete"></i></button>
        <h2 class="text">تم إضافة المشروع الى مفضلتك، للإطلاع على مفضلتك أنقر على <a href="#">الرابط هنا</a></h2>
    </div>
</section>
<section class="confirm_pop1 hidden ">
    <div class="bg_nofication bg_nofication1 "></div>
    <div style="position: relative;width: 100%; height: 39px;">
        <button class="close close_con"><i class="icon-delete"></i></button>
        <h2 class="text" id="msg">هل انت متأكد من العملية</h2>
    </div>
    <div class="confirm">
        <button class="btn btn-danger" id="yesButton">نعم <span class="fa fa-spinner fa-spin hidden"
                                                                id="yesLoader22"></span></button>
        <button class="btn btn-primary close_con">الغاء</button>
    </div>
</section>
<style>
    button.item_get_somebutton1:first-child {
        background: #34ad31;
    }

    button.item_get_somebutton1:last-child {
        background: #fe5339;
    }

    button.item_get_somebutton1 {
        display: inline-block;
        width: 200px;
        /* max-width: 100%; */
        font-size: 14px;
        color: #fff;
        font-weight: bold;
        text-align: center;
        padding: 8px;
        margin: 10px auto;
        border: 0;
        border-radius: 30px;
    }

    .confirm_pop form h1 {
        margin-bottom: 10px
    }

    .confirm_pop form {
        text-align: center;
        font-size: 18px;
    }

    .fa-spinner {
        padding-left: 5px;
        padding-right: 5px;
    }

    .info_perfs .slideTows {
        z-index: 9;
    }
</style>
<section class="confirm_pop" style="z-index: 32;">
    <div class="bg_get_some_error"></div>
    <div class="get_some_error_item">
        <div class="heade_div2">
            <h2 class="title">تأكيد تسليم المشروع</h2>
            <button class="closeConfirm close_get_some"><i class="icon-delete"></i></button>
        </div>
        <div class="item_get_some">
            <form action="javascript:;" class="ajaxForm" style="" method="post">
                <h1 class="contentModal">سوف يتم خصم <span class="amount"></span> دولار من حسابك</h1>
                <h1 class="contentFinishModal hidden">سوف يتم تعليق <span class="amount"></span> دولار من حسابك</h1>
                <button type="button" id="yesButton" class="item_get_somebutton1 btn-success">تأكيد <span
                            class="fa fa-spinner fa-spin hidden" id="yesLoader"></span></button>
                <button type="button" id='noButton' class="item_get_somebutton1 closeConfirm">الغاء</button>
            </form>
        </div>
    </div>
</section>
<section class="nofication_error">
    <div class="bg_nofication"></div>
    <div class="nofication_error_item">
        <button class="close_error"><i class="icon-delete"></i></button>
        <h2 class="text">تم إضافة المشروع الى مفضلتك، للإطلاع على مفضلتك أنقر على <a href="#">الرابط هنا</a></h2>
    </div>
</section>
<section class="confirm_pop1" style="display: none;z-index: 33">
    <div class="bg_get_some_error"></div>
    <div class="get_some_error_item">
        <div style="position: relative;width: 100%; height: 39px;">
            <button class="close close_con"><i class="icon-delete"></i></button>
            <h2 class="text" id="msg">هل انت متأكد من العملية</h2>
        </div>
        <div class="confirm">
            <button class="btn btn-danger" id="yesButton">نعم <span class="fa fa-spinner fa-spin hidden"
                                                                    id="yesLoader1"></span></button>
            <button class="btn btn-primary close_con">الغاء</button>
        </div>
    </div>
</section>
<section class="dropzone_pop" style=" display: none;z-index: 9999;">
    <div class="bg_get_some_error"></div>
    <div class="get_some_error_item">
        <div class="heade_div2">
            <h2 class="title">تأكيد تسليم المشروع</h2>
            <button class="closeDZ close_get_some"><i class="icon-delete"></i></button>
        </div>
        <div class="item_get_some">
            <form action="javascript:;" class="ajaxForm" style="" method="post">
                <h1>هل انت متأكد من العملية ؟</h1>
                <button type="button" id="confirm" class="item_get_somebutton1 btn-success">تأكيد</button>
                <button type="button" id='noButton' class="item_get_somebutton1 closeDZ">الغاء</button>
            </form>
        </div>
    </div>
</section>
<style>
    .ajaxLoader {
        position: fixed;
        color: #fff;
        left: 20px;
        top: 95px;
        display: none;
    }

    .ajaxLoader i {
        font-size: 49px;
        padding: 20px;
    }
</style>
<section class="ajaxLoader">
    <i class="fa fa-spin fa-spinner"></i>
</section>
<script src="/front/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="/front/js/jquery.validate.min.js"></script>
<script src="/front/js/select2.min.js"></script>
<script src="/front/js/localization/messages_ar.js"></script>
<script src="/front/js/noty/jquery.noty.packaged.min.js"></script>
<script src='/front/js/moment.js'></script>
<script src='/front/js/bootstrap-datetimepicker.js'></script>
<script src="/front/js/ion.rangeSlider.js"></script>
<script src="/js/validation/validation.js"></script>
<script src="/js/validation/validation_ar.js"></script>
<script src="/front/js/dropzone.js"></script>
<script>
    $(document).ready(function () {
        $('.logo-img .head-menu5 li').click(function () {
            if ($(this).hasClass('active')) {
                $('.logo-img .head-menu5 li').removeClass("active");
            } else {
                $('.logo-img .head-menu5 li').removeClass("active");
                $(this).addClass("active");
            }
        });
    });
</script>
<script>
    $.ajaxSetup({
        error: function (xhr, textStatus, errorThrown) {
            switch (xhr.status) {
                case 401:
                    break;
                case 422:
                    $.each(xhr.responseJSON, function (key, value) {
                        myNoty(value)
                    });
                    ajax_obj.attr('disabled', false);
                    Loader.hide();

                    break;
                default:
                    break;
            }
        }
    });
    $('body').on('click', '.dropdown-menu li', function () {
        if ($(this).hasClass('project')) {
            return;
        }
        data = $(this).children('a').data('value');
        text = $(this).children('a').text();
        parent = $(this).parent().parent();
        parent.children('button').text(text);
        parent.children('input').val(data);
        parent.children('input').change();
    });
    dropdown_selected();
    function myNoty(msg, type='danger') {
        var n = noty({
            text: '<div class="abed alert alert-' + type + '" style="text-align:center">' + msg + '</p></div>'
            , layout: 'center', //or left, right, bottom-right... danger
            theme: 'made',
            maxVisible: 4,
            timeout: 3000

        });

    }
    var dz_this;
    var dz_file;
    function conCancelUpload(_this, file, title='الغاء الرفع') {
        dz_this = _this;
        dz_file = file;
        $('.dropzone_pop #confirm').click();
    }
    function nofication_good(text, $duration=3500) {
        $('.nofication_good .text').html(text);
        $('.nofication_good').show();
        setTimeout(function () {
            $('.nofication_good').hide();
        }, $duration)
    }

    function nofication_error(text, $duration=3500) {
        $('.nofication_error .text').html(text);
        $('.nofication_error').show();
        setTimeout(function () {
            $('.nofication_error').hide();
        }, $duration)
    }

    $('body').on('click', '.confirmClick', function (e) {
        e.preventDefault();
        $('.confirm_pop').show();
        title = $(this).text();
        info = $(this).data('info');
        if (title)
            $('.confirm_pop .amount').text(' مبلغ ' + info);
        $('.confirm_pop .title').text(title);
        $('.confirm_pop #yesButton').data('href', $(this).data('href'));
    });
    $('body').on('click', '.confirmProjectFinish', function (e) {
        e.preventDefault();
        $('.confirm_pop').show();
        title = $(this).text();
        info = $(this).data('info');
        if (title)
            $('.confirm_pop .contentModal').text('تأكيد إنهاء المشروع');
        $('.confirm_pop .title').text(title);
        $('.confirm_pop #yesButton').data('href', $(this).data('href'));

    });
    $('body').on('click', '.confirmReceiveProject', function (e) {
        e.preventDefault();
        e.preventDefault();
        $('.confirm_pop').show();
        title = "تأكيد إستلام المشروع";
        info = $(this).data('info');
        if (title)
            $('.confirm_pop .amount').text(' مبلغ ' + info);
        $('.confirm_pop .title').text(title);
        $('.confirm_pop #yesButton').data('href', $(this).data('href'));

    });
    $('body').on('click', '.confirmBidsClick', function (e) {
        e.preventDefault();
        $('.confirm_pop').show();
        title = $(this).text();
        info = $(this).data('info');
        if (title)
            $('.confirm_pop .amount').text(' مبلغ ' + info);
        $('.confirm_pop .contentModal').remove();
        $('.confirm_pop .contentFinishModal').removeClass('hidden');
        $('.confirm_pop .title').text(title);
        $('.confirm_pop #yesButton').data('href', $(this).data('href'));

    });
    confirmAjax = false;
    $('body').on('click', '#yesButton', function () {
        if (!confirmAjax) {
            confirmAjax = true;
            $('#yesLoader').removeClass('hidden');
            $.ajax({
                url: $(this).data('href')
            }).done(function (data) {
                if (data.status) {
                    nofication_good(data.msg);
                    location.reload();
                } else {
                }
                if (data.url) {
                    window.location = data.url;
                } else {
                    nofication_error(data.msg, 6000);

                }
            }).fail(function () {
                nofication_error('حصل خطأ غير متوقع');
            }).always(function () {
                $('.confirm_pop').hide();
                $('.confirm_pop #yesButton').data('href', '');
                $('#yesLoader').addClass('hidden');
                confirmAjax = false;

            });
        }
    });


    $('.closeConfirm').click(function () {
        $('.confirm_pop').hide();
        $('.dropzone_pop #confirm').removeClass('cancelUploadDZ');
    });

    $('.dropzone_pop #confirm').click(function () {
        dz_this.removeFile(dz_file);
        $('.dropzone_pop').hide();
    });
    $('.closeDZ').click(function () {
        $('.dropzone_pop').hide();
        $('.dropzone_pop #confirm').data('href', '');
    });


    function showMsg(txt, type='danger', id='msg') {
        $('#msg').empty();
        html = ' <div class="alert alert-' + type + '">' +
            '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' +
            '<p style="text-align: center;">' + txt + '</p>' +
            '</div>';
        $('#' + id).html(html);
        $('#' + id).removeClass('hidden');
        $("html, body").animate({scrollTop: '#' + id}, 1000);
        setTimeout(function () {
//            $('#'+id).addClass('hidden');
//            $('#'+id).empty();
        }, 8000)
    }

    function isNumber($val) {
        var reg = new RegExp(/^[0-9]+$/);
        if (reg.exec($val)) {
            return 1;
        } else {
            return 0;
        }
    }

    function dropdown_selected() {
        $('.dropdown li[selected]').each(function () {
            text = $(this).children('a').text();
            val = $(this).children('a').data('value');
            $(this).parent().parent().children('button').text(text);
            $(this).parent().parent().children('input').val(val);

        });
    }
</script>
<script src="/front/js/function.js"></script>

@yield('script')
<script>
    $('body').on('click', '.publicPaginate .pagination a', function (e) {
        e.preventDefault();
        var elm = $(this);
        getPage(elm);
    });

    $('body').on('submit', '.Ajaxsearch', function (e) {
        e.preventDefault();
        var elm = $(this);
        getResults(elm);
    });

    function getResults(elm) {
        if (!ajaxPaging) {

            ajaxPaging = true;
            icon = elm.find('button').children('i').attr('class');
            elm.find('button').children('i').attr('class', 'fa fa-spin fa-spinner');
            $.ajax({
                url: elm.attr('action'),
                data: elm.serialize()
            }).done(function (data) {
                if (data.status)
                    $('.publicContent').html(data.view);
                else
                    myNoty(data.msg);

                ajaxPaging = false;
            }).complete(function () {
                elm.find('button').children('i').attr('class', icon);

            });
        } else {
            myNoty('الرجاء انتظار جلب البيانات');
        }
    }

    window.onpopstate = function (e) {
        var a = document.createElement("a");
        a.setAttribute('href', e.state.url);
        if (e.state) {
            backPage(e.state.url);
        }
    };
    ajaxPaging = false;
    function getPage(elm) {
        if (!ajaxPaging) {

            elm.html('<i class="fa fa-spinner fa-spin"></i>');
            ajaxPaging = true;
            $.ajax({
                url: elm.attr('href'),
                dataType: 'json',
            }).done(function (data) {
                window.history.pushState({url: "" + elm.attr('href') + ""}, 'title', elm.attr('href') + "&aj");
                $('.publicContent').html(data.view);
                $("body").animate({scrollTop: $('.publicContent').offset().top}, 50);
                ajaxPaging = false;
            }).fail(function () {
                nofication_error('حصل خطأ غير متوقع');
                ajaxPaging = false;

            });
        }
    }

    function backPage(url) {
        if (!ajaxPaging) {
            ajaxPaging = true;
            $.ajax({
                url: url,
                dataType: 'json',
            }).done(function (data) {
                $('.publicContent').html(data.view);
                $("body").animate({scrollTop: $('.publicContent').offset().top}, 50);
                ajaxPaging = false;
            }).fail(function () {
                nofication_error('حصل خطأ غير متوقع');
                ajaxPaging = false;

            });
        }
    }


    var loaderClass;
    function showLoader(obj) {
        if (obj.find('.Loader').length) {
            loaderClass = obj.find('.Loader').attr('class');
            obj.find('.Loader').attr('class', 'fa fa-spin fa-spinner Loader');
        } else if (obj.parent().parent().find('.menuLoader').length) {
            loaderClass = obj.parent().parent().find('.menuLoader').attr('class');
            obj.find('.Loader').attr('class', 'fa fa-spin fa-spinner Loader');
        } else {
            $('.ajaxLoader').show();
        }
    }

    function hideLoader(obj) {
        if (obj.find('.Loader').length) {
            obj.find('.Loader').attr('class', loaderClass);
        } else if (obj.parent().parent().find('.menuLoader').length) {
            obj.parent().parent().find('.menuLoader').attr('class', loaderClass);
        } else {
            $('.ajaxLoader').hide();
        }
    }

    var ajax = false;
    $(function () {
        $('body').on('click', '.ajaxRequest', function (e) {
            e.preventDefault();
            if (!ajax) {
                obj = $(this);
                showLoader(obj);

                ajax = true;
                $.ajax({
                    url: $(this).attr('href')
                }).done(function (data) {
                    if (data.status) {
                        if (data.textType != 'notifaction')
                            nofication_good(data.msg);

                    } else {
                        nofication_error(data.msg);
                    }
                    if (data.textType == 'favorite') {
                        obj.children('span').text(data.text);
                    }

                    if (data.textType == 'notifaction') {
                        $('.notifaction').html(data.view)
                    }
                    hideLoader(obj);

                    if (data.Active) {
                        obj.children('span').text(data.text);
                        if (data.status) {
                            obj.find(data.Active).addClass('active');
                        } else {
                            obj.find(data.Active).removeClass('active');
                        }
                    }
                    if (data.url)
                        window.location = data.url;
                    ajax = false;

                }).fail(function () {
                    //  myNoty('حصل خطأ ما');
                    $('.ajaxLoader').hide();
                    ajax = false;

                });
            } else {
                myNoty('الرجاء انتظار جلب البيانات');
            }
        });
    });


    var ajaxForm = false;
    $(function () {
        $('.ajaxForm').submit(function (e) {

            e.preventDefault();
            var loader = $(this).find('#loader');
            if (!ajaxForm) {
                loader.show();
                ajaxForm = true;
                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: $(this).serialize()
                }).done(function (data) {
                    if (!data.status) {
                        nofication_error(data.msg);
                    } else if (data.status === 1) {
                        nofication_good(data.msg);
                        $('.resultForm').append(data.view);
                        $('.ajaxForm textarea').val('');
                        $('#fileList').empty();
                        if (data.url)
                            window.location = data.url;
                    }
                    ajaxForm = false;
                    loader.hide();

                }).fail(function () {
                    myNoty('حصل خطأ ما');
                    ajaxForm = false;

                    loader.hide();
                });
            } else {
                myNoty('الرجاء انتظار جلب البيانات');
            }
        });
    });


    @if(session()->has('msg'))
            nofication_good('{!!  session('msg')!!}', 4000);

    @endif


@if(session()->has('error'))
       nofication_error('{!!  session('error')!!}', 4000);

    @endif
</script>


<script>
    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        // some code..

        $('.mobilePrevent').click(function (e) {
            e.preventDefault();
        });
    }

</script>


<script>
    unseen ={{session('user')? $templateData['unseenNoti']:0}};
    setInterval(function () {
        $.ajax({
            url: '/getNew',
            data: {unseen: unseen}
        }).done(function (data) {
            if (data.status) {
                $('.message').html(data.message);
                $('.notifaction').html(data.notifaction);
            }
            // myNoty(data.msg);
        }).fail(function () {
            console.log('حصل خطأ ما')
        });
    }, 60000)


    $('.bg_nofication').click(function () {
        $('.nofication_error').hide();
    });

</script>
@if(isset($specializations))
    <script>

        var specializations =<?= json_encode($specializations->keyBy('id')) ?>;
        var allSkills =<?= json_encode($skills) ?>;
        $('[name=specialization_id]').change(function () {
            id = $(this).val();
            var html = "";
            if (id != 0) {
                var skills = specializations[id]['skills'];
            } else {
                var skills = [];
            }
            console.log(skills);
            skills.forEach(function (element) {
                html += "<option value='" + element['id'] + "'>" + element['name'] + "</option>";
            });


            $('[name="skills[]"]').html(html);
        });
    </script>
@endif
</body>
</html>