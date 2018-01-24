@extends('front.__template')

@section('title','اعادة تعين كلمة المرور')


@section('content')
    <section class="s_404">
        <div class="container">
            <div class="heade_div404">
                <div class="heade_div">
                    <h2>اعادة تعيين كلمة المرور</h2>
                </div>

                <form action="/resetPassword" method="post">
                    <div class="item_div2">
                    <div class="col-md-6 col-md-offset-3">
                            <div class="login">
                            <div  class="hidden" id="msg"> </div>
                            {{csrf_field()}}
                            <input type="hidden" name="token" value="{{$token}}">
                            <div class="pass">
                                <label>كلمة المرور</label>
                                <div class="passs">
                                    <input type="password" id="password" minlength="5" required name="password" value="" placeholder="كلمة المرور">
                                </div>
                            </div>
                            <div class="pass">
                                <label>تأكيد كلمة المرور</label>
                                <div class="passs">
                                    <input type="password" minlength="5" required name="password_confirmation" value="" placeholder=" تأكيد كلمة المرور">
                                </div>
                            </div>
                            <button> <i class="fa fa-spin fa-spinner hidden" id="formLoader"></i>   اعادة تعيين </button>
                        </div>
                    </div>
                </div>
                </form>

            </div>
        </div>
    </section>

@endsection

@section('script')
    <script>
        $('form').validate({
            rules:{
                password_confirmation:{
                    equalTo:'#password'
                }
            }
        });
        var loginClick=false;
        $('form').submit(function(e){
            e.preventDefault();
            if(!loginClick&&$('form').valid()) {
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
                        else {
                            showMsg('تم اعادة تعين كلمة المرور بنجاح','success');
                            setTimeout(function () {
                                window.location.href = '/';
                            },2500)
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