<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="/panel/images/favicon.png" type="image/png">

    <title>نسيت كلمة المرور </title>

    <link href="/panel/css/style.default.css" rel="stylesheet">

    <link href="/panel/css/style.default-rtl.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="/panel/js/html5shiv.js"></script>
    <script src="/panel/js/respond.min.js"></script>
    <![endif]-->
</head>

<body class="signin">

<!-- Preloader -->
<div id="preloader">
    <div id="status"><i class="fa fa-spinner fa-spin"></i></div>
</div>

<style>
     @import url(http://fonts.googleapis.com/earlyaccess/droidarabickufi.css);

            h1,h2,h3,h4,h5,h6,div,tr,td,table,thead th,tr th,.table thead > tr > th,.pageheader,input,.pageheader h2,.logopanel h1{
                font-family: 'Droid Arabic Kufi', serif !important;
            }
</style>
<section>

    <div class="signinpanel">

        <div class="row">
            <div class="col-md-6 col-md-offset-3">

                {!! Form::open(['url' => route('handle_Forget'), 'class' => '']) !!}
                    <h4 class="nomargin">نسيت كلمة المرور</h4>
                    <?php if(session()->has('msg')){ ?>
                        <h5 class="alert-danger alert"><?=session()->get('msg') ?></h5>
                    <?php }?>
                    <input type="text" value="{{old('email')}}" name="email" class="form-control uname" placeholder="البريد الإلكتروني" />
                    {{ csrf_field() }}
                    <a href="{!! route('login') !!}"><small>تسجيل الدخول</small></a>
                    <button class="btn btn-success btn-block">اعادة تعين</button>

                {!! Form::close() !!}
            </div><!-- col-sm-5 -->

        </div><!-- row -->

        

    </div><!-- signin -->

</section>


<script src="/panel/js/jquery-1.11.1.min.js"></script>
<script src="/panel/js/jquery-migrate-1.2.1.min.js"></script>
<script src="/panel/js/bootstrap.min.js"></script>
<script src="/panel/js/modernizr.min.js"></script>
<script src="/panel/js/retina.min.js"></script>
<script src="/panel/js/noty/jquery.noty.packaged.min.js"></script>
<script type="text/javascript">

    jQuery(window).load(function() {

        "use strict";

        // Page Preloader
        jQuery('#preloader').delay(350).fadeOut(function(){
            jQuery('body').delay(350).css({'overflow':'visible'});
        });
    });

</script>
{{--<script src="/panel/js/custom.js"></script>--}}
    <script type="text/javascript">
            @if(count($errors))

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
</script>
</body>
</html>
