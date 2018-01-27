@extends('front.__template')

@section('title','استعادة كلمة المرور')


@section('content')
    <section class="s_404">
        <div class="container">
            <div class="heade_div404">
                <div class="heade_div">
                    <h2>إسترجاع كلمة المرور</h2>
                </div>
                <div class="item_div2">
                    <div class="col-md-6 col-md-offset-3">
                        <form action="/handleForgetPassword" method="post">
                            <div  class="hidden" id="msg"> </div>

                            <div class="forget_pass">
                                {{csrf_field()}}
                                <label>بريدك الإلكتروني</label>
                                <div class="forget_passs">
                                    <input required type="email" name="email" placeholder="بريدك الإلكتروني">
                                </div>
                                <button>استعادة كلمة المرور <i class="fa fa-spin fa-spinner hidden" id="formLoader"></i></button>
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
        $('form').validate();

        var forgetClick=false;
        $('form').submit(function(e){
            e.preventDefault();
            if(!forgetClick&&$('form').valid()) {
                forgetClick=true;
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
                            showMsg('تم ارسال بريد الى حسابك لإعادة تعين كلمة المرور','success');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert(textStatus);
                    },
                    complete: function (data, status) {
                        forgetClick=false;
                        $('#formLoader').addClass('hidden');
                    }
                });
            }



        });
    </script>
@endsection