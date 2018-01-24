@extends('front.__template')
@section('title','تسجيل الدخول')



@section('content')
    <section class="s_404">
        <div class="container">
            <div class="heade_div404">
                <div class="heade_div">
                    <h2>تسجيل الدخول</h2>
                </div>

                <form action="/handleLogin" method="post">
                    <div class="item_div2">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="login">
                            <div  class="hidden" id="msg"> </div>
                            <div class="email">
                                <label>البريد الإلكتروني او رقم الجوال</label>
                                <div class="emails">
                                    <input type="text" placeholder=" البريد الإلكتروني او رقم الجوال" required name="email">
                                </div>
                            </div>
                            {{csrf_field()}}
                            <div class="pass">
                                <label>كلمة المرور</label>
                                <div class="passs">
                                    <input type="password" minlength="5" placeholder="كلمة المرور" required name="password" value="">
                                </div>
                            </div>

                            <button> <i class="fa fa-spin fa-spinner hidden" id="formLoader"></i>   دخول </button>
                            <a href="/forgetPassword" class="forget">نسيت كلمة المرور؟</a>
                            <div class="or-item">
                                <span>أو</span>
                            </div>
                            <ul>
                                <li><a href="/loginFacebook" class="face"><i class="icon-facebook"></i>فيسبوك</a></li>
                                <li><a href="/loginTwitter" class="Twitter"><i class="icon-twitter"></i>تويتر</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                </form>
                <div class="dont_have">
                    <h2>لا تمتلك حساب في إنجزلي</h2>
                    <div class="btn_reqs">
                        <button  onclick="window.location.href='/register'">إنشاء حساب جديد</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('script')
    <script>
        $('form').validate();

        var loginClick=false;
        $('form').submit(function(e){
            e.preventDefault();
            if(!loginClick) {
                loginClick=true;
                $('#formLoader').removeClass('hidden');
                url=$(this).attr('action');
                $.ajax({
                    method: "POST",
                    url: url,
                    dataType: 'json',
                    data: $(this).serialize(),
                    success: function (data, textStatus, jqXHR) {
                        if(!data.status)
                            showMsg(data.msg);
                        else if(data.status===2){
                            showMsg('لا يمكنك تسجيل الدخول برقم الجوال','danger')
                        } else{
                            showMsg('تم تسجيل الدخول بنجاح','success');
                            setTimeout(function () {
                                if(data.isFinishProfile||1){
                                       href='/singleUser';
                                }else{
                                    href='/editProfile';
                                }
                                window.location.href = href;
                            },1500)
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert(textStatus);
                    },
                    complete: function (data, status) {
                        loginClick=false;
                        $('#formLoader').addClass('hidden');
                    }
                });
            }



        });
    </script>
@endsection