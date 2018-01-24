<!doctype html>
<html lang="ar" class="no-js">
    <?php global $setting; ?>

    <head>
        <title>{{$setting['title']}}</title>
         @include('front/template_header')
      <link rel="shortcut icon" type="image/png" href="/front/images/handshake.ico"/>
<link rel="shortcut icon" type="image/png" href="/front/images/handshake.ico"/>

        <!-- <meta name="theme-color" content="#000"> -->
        <link rel="stylesheet" href="/front/css/bootstrap.min.css">
        <link rel="stylesheet" href="/front/css/bootstrap-rtl.css">
        <link rel="stylesheet" href="/front/css/bootstrap-select.css">
        <link rel="stylesheet" href="/front/css/font-style.css">
        <link rel="stylesheet" href="/front/css/style.css">


        <style type="text/css">
            section.header-section-owl{
                min-height: 100vh;
            }
            .video-container {
                position: relative;
                padding-bottom: 56.25%;
                padding-top: 30px; height: 0; overflow: hidden;
                float: right;width: 100%;
                margin-top: 30px;
            }
            .logo-img p {
                float: right;
                color: #fff;
                padding-top: 7px;
                padding-right: 5px;
                font-size: 14px;
            }
            .logo-img a {
                float: right;
            }
            .video-container iframe,
            .video-container object,
            .video-container embed {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
            }
            .header-section-owl.supper:after{
                content: '';
                position: absolute;
                left: 0;
                right: 0;
                top: 0;
                bottom: 0;
                background: url(/front/images/bg_supper.png)no-repeat center top;
                background-size: cover;
                z-index: -1;
                opacity: 0.5;
            }
            section.header-section-owl.supper .item-slider1-index{
                padding-top: 14%;
                position: relative;
            }
            section.header-section-owl.supper .item-slider1-index:after{
                content: '\e901';
                font-family: 'icomoon';
                position: absolute;
                left: 0;
                right: 0;
                bottom: 20px;
                font-size: 20px;
                color: #fff;
            }
            section.header-section-owl.supper .item-slider1-index h3{
                font-size: 24px;
            }
            .vedio_supper {
                float: right;
                width: 100%;
            }
            .vedio_supper p {
                float: right;
                width: 100%;
                color: #8c8c8c;
                font-size: 16px;
                text-align: center;
                margin-top: 20px;
                margin-bottom: 50px;
            }
            section.s_2.supper {
                padding: 70px 0;
                background: #555555;
                position: relative;
            }
            section.s_2.supper .item_s2 {
                padding: 50px 0;
            }
            section.s_2.supper .header_s_3 h2{
                color: #fff;
                padding-bottom: 5px;
            }
            .s_2.supper:before{
                content: '';
                position: absolute;
                left: 0;
                right: 0;
                top: 0;
                bottom: 0;
                background: url(/front/images/bg_buy.png)no-repeat center top;
                background-size: /front/imagesscover;
                /*z-index: -1;*/
                opacity: 0.6;
            }
            .s_2.supper>div{
                position: relative;
                z-index: 1;
            }
            .s_2.supper .first_item_s2 h2{
                color: #fff;
                padding-bottom: 5px;
            }
            .s_3.supper h4.panel-title a {
                display: block;
                font-size: 16px;
                color: #8c8c8c;
                position: relative;
                padding-right: 25px !important;
                cursor: pointer;
            }
            .s_3.supper h4.panel-title a:after {
                content: '';
                position: absolute;
                right: 0;
                top: 10px;
                background: url(/front/images/left.png)no-repeat center center;
                background-size: 100%;
                width: 15px;
                height: 10px;
                -webkit-transition: all 500ms ease;
                -moz-transition: all 500ms ease;
                -o-transition: all 500ms ease;
                transition: all 500ms ease;
            }
            .s_3.supper .panel-heading {
                background: #fff !important;
                border-radius: 0 !important;
                padding: 20px;
            }
            .s_3.supper .panel-body {
                font-size: 14px;
                color: #8c8c8c;
            }
            .s_3.supper .panel.panel-default {
                border-radius: 0 !important;
                border: 1px solid #e1e1e1;
                margin-bottom: 30px;
            }
            section.s_10.supper {
                float: right;
                width: 100%;
                background: #f5f5f5;
                padding: 50px 0;
            }
            .supper_test h2 {
                float: right;
                width: 100%;
                color: #414140;
                font-size: 22px;
                padding-bottom: 10px;
            }
            .supper_test a {
                float: right;
                width: 100%;
                color: #fff;
                background: #fe5339;
                font-size: 18px;
                padding: 10px;
                cursor: pointer;
            }
            .supper_test {
                float: right;
                width: 100%;
                text-align: center;
            }
            .panel-group {
                display: inline-block;
                width: 100%;
                margin-bottom: 0;
            }
            .item_get_some input, .item_get_some textarea{
                float: right;
                width: 100%;
                padding: 8px;
                color: #787878;
                font-size: 14px;
                background: #f3f4f5;
                border: 1px solid #e5e6e8;
                border-radius: 5px;
                margin-bottom: 20px;
            }
            .item_get_some select{
                float: right;
                width: 100%;
                padding: 8px;
                color: #787878;
                font-size: 14px;
                background: #f3f4f5;
                border: 1px solid #e5e6e8;
                border-radius: 5px;
            }
            .get_some_error_item{
                top: 14%;
            }
            .item_get_some .asdselect {
                float: right;
                width: 100%;
                position: relative;
                margin-bottom: 20px;
            }
            .item_get_some .asdselect:after {
                content: '\e901';
                font-family: 'icomoon', sans-serif;
                position: absolute;
                color: #b5b5b5;
                font-size: 10px;
                left: 10px;
                top: 15px;
                z-index: 1px;
            }
            .modal {
                text-align: center;
                padding: 0!important;
            }

            .modal:before {
                content: '';
                display: inline-block;
                height: 100%;
                vertical-align: middle;
                margin-right: -4px;
            }

            .modal-dialog {
                display: inline-block;
                text-align: left;
                vertical-align: middle;
            }
            .modal-content {
                display: inline-block;
            }
            .item_some h2, .item_get_some h2, .item_get_some2 h2{
                text-align: right;
            }
            body.modal-open{
                padding-right: 0 !important;
            }
          .btn-group.bootstrap-select {
    float: right;
    width: 100% !important;
}
          button.btn.dropdown-toggle {
    padding: 10px;
    padding-left: 30px;
}
          .btn-group.open .dropdown-toggle{
            box-shadow:none;
          }
          .item_get_some .asdselect:after {
    content: '\e901';
    font-family: 'icomoon', sans-serif;
    position: absolute;
    color: #b5b5b5;
    font-size: 10px;
    left: 10px;
    top: 17px;
    z-index: 1;
}
          .btn-group-vertical>.btn.active, .btn-group-vertical>.btn:active, .btn-group-vertical>.btn:focus, .btn-group-vertical>.btn:hover, .btn-group>.btn.active, .btn-group>.btn:active, .btn-group>.btn:focus, .btn-group>.btn:hover {
    z-index: 1;
}
          .bootstrap-select.btn-group .dropdown-toggle .filter-option {
    text-align: right;
}
          
        </style>

    </head>
    <body>
        <section class="header-section-owl supper">
            <div class="container">
                <div class="header">
                    <div class="menu-side">
                        <div class="btn-menu-close"><i class="fa fa-times"></i></div>
                        <ul class="menu-sidebar">
                            <li><a href="">الرئيسية</a></li>
                            <li><a href="">من نحن</a></li>
                            <li><a href="">بيئة العمل</a></li>
                            <li><a href="">الخصوصية</a></li>
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
                                                    <a href="#"><h2>إنجزلي</h2><p>سوبر</p></a>
                                                </div>
                                            </div><!-- /.container-fluid -->
                                        </nav>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-3 pull-left navigation">
                                        <nav class="navbar navbar-default">
                                            <div class="container-fluid">
                                                <div class="collapse navbar-collapse" id="defaultNavbar1">
                                                    <ul class="head-menu4 nav navbar-nav avbar-left">
                                                        @if(session('user')['id'])
                                                        <li><a href="/singleUser" class="a_bord">حسابي</a></li>
                                                        @else
                                                        <li><a href="/register" class="a_bord">حساب جديد</a></li>
                                                        <li><a href="/login">دخول</a></li>
                                                        @endif
                                                    </ul>
                                                </div><!-- /.navbar-collapse -->
                                            </div><!-- /.container-fluid -->
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item-slider1-index super">
                    <img src="/front/images/supper.png">
                    <h2>إنجزلي سوبر</h2>
                    <h3>{{$setting['super_header_text']}}</h3>
                </div>
            </div>
        </section>
        <section class="s_3 supper">
            <div class="container">
                <div class="col-md-12">
                    <div class="header_s_3">
                        <h2>ما هي خدمة إنجزلي سوبر</h2>
                    </div>
                </div>
                <div class="col-md-8 col-md-offset-2">
                    <div class="vedio_supper">
                        <div class="video-container">
                            <iframe width="100%" height="400" src="{{$setting['super_video_url']}}" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                        </div>
                        <p>{{$setting['super_paragraph']}}</p>
                    </div>
                </div>
            </div>
        </section>
        <section class="s_2 supper">
            <div class="container">
                <div class="col-md-12">
                    <div class="header_s_3">
                        <h2>كيف نعمل؟</h2>
                    </div>
                </div>
                <div class="item_s2">
                    <div class="first_item_s2 red">
                        <span><img src="/front/images/add.png"></span>
                        <h2>أرسل بيانات مشروعك</h2>
                        <p>1</p>
                    </div>
                    <div class="first_item_s2 blue">
                        <span><img src="/front/images/user.png"></span>
                        <h2>نتواصل معك</h2>
                        <p>2</p>
                    </div>
                    <div class="first_item_s2 orange">
                        <span><img src="/front/images/clock.png"></span>
                        <h2>إستلم مشروعك</h2>
                        <p>3</p>
                    </div>
                </div>
            </div>
        </section>
        <section class="s_3 supper">
            <div class="container">
                <div class="col-md-12">
                    <div class="header_s_3">
                        <h2>أسئلة شائعة</h2>
                    </div>
                </div>
                <div class="col-md-6">
                    <?php
                    $half = ceil($faqs->count() / 2);
                    ?>
                    @for($i=0;$i<$half;$i++)
                    <div class="col-md-12">
                        <div class="panel-group" id="accordion">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$faqs[$i]->id}}" class="collapsed">
                                            {{$faqs[$i]->question}}</a>
                                    </h4>
                                </div>
                                <div id="collapse{{$faqs[$i]->id}}" class="panel-collapse collapse">
                                    <div class="panel-body"> {{$faqs[$i]->answer}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endfor

                </div>
                <div class="col-md-6">
                    @for($i=$half;$i<$faqs->count();$i++)

                    <div class="col-md-12">
                        <div class="panel-group" id="accordion{{$faqs[$i]->id}}">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion2" class="collapsed" href="#collapse{{$faqs[$i]->id}}">
                                            {{$faqs[$i]->question}}</a>
                                    </h4>
                                </div>
                                <div id="collapse{{$faqs[$i]->id}}" class="panel-collapse collapse">
                                    <div class="panel-body"> {{$faqs[$i]->answer}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endfor

                </div>
            </div>
        </section>
        <section class="s_10 supper">
            <div class="container">
                <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
                    <div class="supper_test">
                        <h2>يمكنك الوثوق بنا، لمشروع مميز ورائع</h2>
                        <a data-toggle="modal" data-target="#myModal">تواصل معنا الأن</a>
                    </div>
                </div>
            </div>
        </section>


           @include('front/template_footer')



        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="heade_div2">
                        <h2>املأ هذه البيانات وانتظر تواصلنا معك</h2>
                        <button class="close_get_some" data-dismiss="modal" aria-label="Close"><i class="icon-delete"></i></button>
                    </div>
                    <div class="item_get_some">
                        <form action="/sendSuper" method="post" id="sendVIP">
                            {{csrf_field()}}
                            <div class="col-md-6">
                                <h2>اسمك الكامل <span>*</span></h2>
                                <input type="text" name="fullname" required="" minlength="5">
                            </div>
                            <div class="col-md-6">
                                <h2>بريدك الالكتروني <span>*</span></h2>
                                <input type="email" name="email" required="" >
                            </div>
                            <div class="col-md-6">
                                <h2>المشروع المطلوب <span>*</span></h2>
                                <div class="asdselect">
                                    {{Form::select('specialization_id',$specializations ,null, array('class'=>'selectpicker'))}}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h2>الميزانية <span>*</span></h2>
                                <div class="asdselect">
                                    <select name="budget_id" class="selectpicker" >
                                        @foreach($budget as $value)
                                        <option value="{{$value->id}}">{{$value->fBudget()}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <h2>تفاصيل المشروع <span>*</span></h2>
                                <textarea rows="6" name="details" required="" minlength="25"></textarea>
                            </div>
                            <button class="item_get_somebutton">أرسل طلب المشروع</button>
                            <strong>أو تواصل من خلال البريد الالكتروني:     <a href="mailTo:{{$setting['vip_email']}}">{{$setting['vip_email']}}</a></strong>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
<section class="nofication_good">
    <div class="bg_nofication"></div>
    <div class="nofication_good_item">
        <button class="close_good"><i class="icon-delete"></i></button>
        <h2 class="text"></h2>
    </div>
</section>
        
        
        <section class="nofication_error">
    <div class="bg_nofication"></div>
    <div class="nofication_error_item">
        <button class="close_error"><i class="icon-delete"></i></button>
        <h2 class="text"></h2>
    </div>
</section>

        <style>

            label.error{
                float:right;
                color:red;
                margin-bottom: 5px;
                text-align: right;
            }
            input.error,textarea.error{
                margin-bottom: 5px;
                border-color: red;
            }
            </style>
            <script src="/front/js/jquery.min.js"></script>
            <script src="/front/js/bootstrap-select.js"></script>
            <script src="/front/js/jquery.validate.min.js"></script>
            <script src="/front/js/localization/messages_ar.js"></script>
  <script>
    $('.selectpicker').selectpicker({});
  </script>
            <script src="/front/js/bootstrap.min.js"></script>
            <script src="/front/js/function.js"></script>

      <script>
        $(document).ready(function(){
          $('a.collapsed').click(function(){
//             alert();
            $('.s_3.supper').find('.panel-collapse').removeClass('in');
            $(this).parent().parent().find('.panel-collapse').addClass('in');
          });
        });
      </script>
            <script>
                
                  function nofication_good(text,$duration=3500) {
        $('.nofication_good .text').html(text);
        $('.nofication_good').show();
        setTimeout(function () {
            $('.nofication_good').hide();
        },$duration)
    }
    
    
    
    function nofication_error(text,$duration=3500) {
        $('.nofication_error .text').html(text);
        $('.nofication_error').show();
        setTimeout(function () {
            $('.nofication_error').hide();
        },$duration)
    }
$(function () {
    $('#sendVIP').validate();
    
    
    
    
    
    
    @if(session()->has('msg'))
            nofication_good('{!!  session('msg')!!}',4000);

         @endif


    @if(session()->has('error'))
            nofication_error('{!!  session('error')!!}',4000);

         @endif
})
            </script>
        </body>
    </html>