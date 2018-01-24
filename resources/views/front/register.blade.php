@extends('front.__template')
@section('title','تسجيل حساب جديد')

@section('content')
  <style>
  .selectss.haveshp button {
    border-top-right-radius: 0 !important;
    border-bottom-right-radius: 0 !important;
    border-radius:35px;
    background: #fff;
    height: 38.8px !important;
    border-right: 0 !important;
    background-image: none !important;
    margin: 0 !important;
}
    .selects button {
    border-radius: 35px !important;
}
    
</style>
    <section class="s_404">
        <div class="container">
            <div class="heade_div404">
                <div class="heade_div">
                    <h2>التسجيل</h2>
                </div>
                <div class="item_div2">
                    <div class="col-md-6 col-md-offset-3">
                        <form action="/handleRegister" method="post">
                            <div  class="hidden" id="msg"> </div>

                            <div class="login">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="user">
                                        <label>الأسم الاول <span>*</span></label>
                                        <div class="users">
                                            <input required placeholder="الإسم الأول" type="text" minlength="3" name="fname">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="user">
                                        <label>الأسم الأخير <span>*</span></label>
                                        <div class="users">
                                            <input required type="text" placeholder="الاسم الأخير" name="lname"  minlength="3">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="email">
                                <label>بريدك الإلكتروني <span>*</span></label>
                                <div class="emails">
                                    <input type="email" required placeholder="البريد الإلكتروني" name="email">
                                </div>
                            </div>
<!--                             <div class="phone">
                                <label>رقم الجوال <span>*</span></label>
                                <div class="phones">
                                    <input type="text" required placeholder="رقم الجوال" minlength="5" name="mobile">
                                </div>
                              
                                <div class="selectss haveshp">
                                    <div class="dropdown">
                                      <button class="btn dropdown-toggle" type="button" data-toggle="dropdown">{{sizeof($countries)?($countries[0]->code.' +'.$countries[0]->zipCode):''}}
                                      <span class="caret"></span></button>
                                      <ul class="dropdown-menu">
                                        @foreach($countries as $country)
                                        <li><a href="javascript:;" data-value="{{$country->id}}">{{$country->code.' +'.$country->zipCode}}</a></li>
                                        @endforeach
                                      </ul>
                                      <input type="hidden" value="{{sizeof($countries)?$countries[0]->id:''}}" class="drop_sel" name="mobile_country_id" />
                                    </div>
                                </div>
                            </div> -->
                            <div class="pass">
                                <label>كلمة المرور <span>*</span></label>
                                <div class="passs">
                                    <input type="password" placeholder="كلمة المرور" id="password" required minlength="5" name="password" value="">
                                </div>
                            </div>

                       {{--      <div class="pass">
                                <label>تاكيد كلمة المرور <span>*</span></label>
                                <div class="passs">
                                    <input type="password" placeholder="تاكيد كلمة المرور" id="password" required minlength="5" name="password_confirmation" value="">
                                </div>
                            </div> --}}


                                 {{csrf_field()}}
                             <div class="pass">
                                 <label>تأكيد كلمة المرور <span>*</span></label>
                                 <div class="passs">
                                     <input type="password" placeholder="تأكيد كلمة المرور" required name="password_confirmation" value="">
                                 </div>
                             </div>
<!--                             <div class="cuntry">
                                <label>الدولة<span>*</span></label>
                                <div class="selects">
                                    <div class="dropdown">
                                      <button class="btn dropdown-toggle" type="button" data-toggle="dropdown">{{sizeof($countries)?$countries[0]->name:''}}
                                      <span class="caret"></span></button>
                                      <ul class="dropdown-menu">
                                        @foreach($countries as $country)
                                        <li><a href="javascript:;" data-value="{{$country->id}}">{{$country->name}}</a></li>
                                        @endforeach
                                      </ul>
                                      <input type="hidden" value="{{sizeof($countries)?$countries[0]->id:''}}" class="drop_sel" name="country_id" />
                                    </div>
                                </div>
                              
                            </div> -->
                            <h2 class="fagree">بإنشائك لحساب جديد في موقع إنجزلي هذا يعني موافقتك على <a href="/page/Conditions">الشروط والأحكام</a> و <a href="/page/Privacy">سياسية الخصوصية</a></h2>
                            <button class="full-w"> <i class="fa fa-spin fa-spinner hidden" id="formLoader"></i>تسجيل </button>
                            <div class="or-item">
                                <span>أو</span>
                            </div>
                            <ul>
                                <li><a href="/loginFacebook" class="face"><i class="icon-facebook"></i>فيسبوك</a></li>
                                <li><a href="/loginTwitter" class="Twitter"><i class="icon-twitter"></i>تويتر</a></li>
                            </ul>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('script')

    <script>

        $(document).ready(function(){
             $(".js-example-basic-multiple").select2({
               placeholder: "الرجاء الاختيار",
               dir: "rtl"
             });

        });

        $('form').validate({
            rules:{
                password_confirmation:{
                    equalTo:'#password'
                }
            }
        });
        var registerClick=false;

        $('form').submit(function(e){
            e.preventDefault();
            if((!registerClick)&&$('form').valid()) {
                registerClick=true;
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
                        else {
                            showMsg('تم التسجيل بنجاح ,ارسلنا لك رسالة تأكيد على البريد الإلكتروني','success');
                            setTimeout(function () {
                                window.location.href = '/login';
                            },1500)
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert(textStatus);
                    },
                    complete: function (data, status) {
                        registerClick=false;
                        $('#formLoader').addClass('hidden');
                    }
                });
            }



        });


    </script>
@endsection