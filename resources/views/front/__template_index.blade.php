<?php global $setting;?>
<!doctype html>
<html lang="ar" class="no-js">
<head>
<title>@yield('title')</title>
@include('front/template_header')
<link rel="shortcut icon" type="image/ico" href="/front/images/favicon.ico" />
<link rel="stylesheet" href="front/css/bootstrap.min.css">
<link rel="stylesheet" href="front/css/bootstrap-rtl.css">
<link rel="stylesheet" href="front/css/font-style.css">
<link rel="stylesheet" href="front/css/style.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="/front/font/flaticon.css"> 
<script src="front/js/jquery.min.js"></script>
</head>
<body>
<section class="header-section-owl">
    <div class="container">
        <div class="header">
            <div class="menu-side">
                <div class="btn-menu-close"><i class="fa fa-times"></i></div>
                <ul class="menu-sidebar">
                    <li><a href="">الرئيسية</a></li>
                    <li><a href="/page/About">من نحن</a></li>
                    <li><a href="/page/Privacy">الخصوصية</a></li>
                    <li><a href="/projects">المشاريع</a></li>
                </ul>
            </div>
            <div class="back-menu"></div>
            <div id="main-menu">
                <div class="btn-menu"><i class="fa fa-bars"></i></div>
                <div class="header-2">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-9 col-sm-9 col-xs-9 pull-right navigation">
                                <nav class="navbar navbar-default">
                                    <div class="container-fluid">
                                        <div class="logo-img">
                                            <a href="/projects"><h2>انجزلي</h2></a>
                                        </div>
                                        <div class="collapse navbar-collapse" id="defaultNavbar1">
                                            <ul class="head-menu3 nav navbar-nav avbar-right">
                                                <li><a href="" class="active">الرئيسية</a></li>
                                                <li><a href="/page/About">من نحن</a></li>
                                                <li><a href="/page/Privacy">الخصوصية</a></li>
                                                <li><a href="/projects">المشاريع</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="item-slider1-index">
						<img src="front/images/logo.png">
            <h3>{{$setting['home_header_text']}}</h3>
            <ul>
              @if(session('user'))
                <li><a href="/editProfile" class="bg_red">الملف الشخصي</a></li>
              @else
                <li><a href="/login">دخول</a></li>
                <li><a href="/register" class="bg_red">حساب جديد</a></li>
              @endif
            </ul>
        </div>
    </div>
</section>
@yield('content')
<section class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="item_footer">
                    <div class="col-md-6 col-sm-6">
                        <div class="item_footer_first">
                            <h3 class="hed_foter">حول الموقع</h3>
                            <h2>إنجزلي</h2>
                            <p>{{$setting['footer_text']}}</p>
                            <p>{{$setting['siteLicense']}}</p>
                      </div>
                    </div>
                  <div class="col-md-2 col-sm-2">
                        <div class="item_footer_first">
                            <h3 class="hed_foter">روابط</h3>
                            <ul class="page_footer">
                                <li><a href="/">الرئيسية</a></li>
                                <li><a href="/page/About">من نحن</a></li>
                                <li><a href="/page/Privacy">سياسة الخصوصية</a></li>
                                <li><a href="/page/Conditions">سياسة الإستخدام</a></li>
                                <li><a href="/FAQ">الأسئلة الشائعة</a></li>
                                <li><a href="/Contact">الإتصال بنا</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <div class="item_footer_first">
                            <div class="item_footer_firstimg">
                                <a target="_blank" href="{{ empty($setting['ios'])?$settings->get('ios')->set_data:$setting['ios']}}"><img src="/front/images/Download.png" title="ios"></a>
                                <a target="_blank" href="{{ empty($setting['android'])?$settings->get('android')->set_data:$setting['android']}}"><img src="/front/images/android.png" title="android"></a>
                            </div>
                            <ul class="soial">
                               @if($setting['twitter'])<li><a target="_blank" href="{{$setting['twitter']}}"><i class="icon-twitter"></i></a></li>@endif
                               @if($setting['facebook'])<li><a target="_blank" href="{{$setting['facebook']}}"><i class="icon-facebook"></i></a></li>@endif
                               @if($setting['google'])<li><a target="_blank" href="{{$setting['google']}}"><i class="icon-google-plus"></i></a></li>@endif
                               @if($setting['linkedin']) <li><a target="_blank" href="{{$setting['linkedin']}}"><i class="icon-linkedin2"></i></a></li>@endif
                            </ul>
                            <ul class="soial-pay">
                                <li><i class="fa fa-fw fa-cc-paypal"></i></li>
                                <li><i class="fa fa-fw fa-cc-visa"></i></li>
																<li><i class="fa fa-fw fa-cc-mastercard"></i></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="item_footer2">
                    <h2>{{$setting['copyRights_text']}}</h2>
                    <h2>{{date('Y')}}  © {{$setting['copyRights']}} </h2>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="front/js/bootstrap.min.js"></script>
<script src="front/js/function.js"></script>
<script src="/front/js/noty/jquery.noty.packaged.min.js"></script>
<script type="text/javascript">
	window.onload = function setDataSource() {
		if (!!window.EventSource) {
			var source = new EventSource("/testnoti");

			source.addEventListener("message", function(e) {
				updatePrice(e.data);
				logMessage(e);
			}, false);
			
			source.addEventListener("open", function(e) {
				logMessage("OPENED");
			}, false);

			source.addEventListener("error", function(e) {
				logMessage("ERROR");
				if (e.readyState == EventSource.CLOSED) {
					logMessage("CLOSED");
				}
			}, false);
		} else {
			document.getElementById("notSupported").style.display = "block";
		}
	}
</script>
@yield('script')
</body>
</html>