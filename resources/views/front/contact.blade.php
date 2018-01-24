@extends('front.__template')
@section('title','تواصل معنا')
@section('styles')
    <script src="https://www.google.com/recaptcha/api.js?language=ar" async defer></script>

@endsection
@section('content')
    <section class="s_404">
        <style>
            .selects2 {
                margin-bottom: 20px;
            }

        </style>
        <div class="container">
            <div class="heade_div404">
                <div class="heade_div">
                    <h2>اتصل بنا</h2>
                </div>
                <div class="item_div2">
                    <form method='post' action='/Contact' class='ajaxForm_in'>
                        <div class="col-md-8 col-md-offset-2">
                            <div class="text_div2">

                                <label>البريد الإلكتروني<span>*</span></label>
                                <input type="email" name="email"
                                       value="{{session( 'user')?session( 'user')[ 'email']: ''}}" required
                                       placeholder="عنوان البريد الإلكتروني">


                                <label>عنوان الرسالة<span>*</span></label>
                                <input type="text" name="title" class=empty required minlength=5
                                       placeholder="عنوان الرسالة">
                                <label>نوع الإتصال<span>*</span></label>
                                <div class="selects2">
                                    <div class="dropdown">
                                        <button class="btn dropdown-toggle" type="button"
                                                data-toggle="dropdown">{{sizeof($problems)?$problems[0]->value:''}}
                                            <span class="caret"></span></button>
                                        <ul class="dropdown-menu dropdown-menu-width">
                                            @foreach($problems as $problem)
                                                <li><a href="javascript:;"
                                                       data-value="{{$problem->id}}">{{$problem->value}}</a></li>
                                            @endforeach
                                        </ul>
                                        <input type="hidden" value="{{sizeof($problems)?$problems[0]->id:''}}"
                                               class="drop_sel" name="problem_id"/>
                                    </div>
                                </div>
                                <label>نص الرسالة<span>*</span></label>
                                <textarea rows="6" name='message' class=empty required minlength='50'></textarea>
                            </div>
                            <div class="recaptchas">
                                <div class="g-recaptcha" data-sitekey="6LcC-DEUAAAAACDn-pE6pgTZi5Dwk3MZPb0AuYcR"></div>
                            </div>
                            {{csrf_field()}}
                            <div class="btn_reqs">
                                <button>إرسال
                                    <i class='fa fa-spin fa-spinner' style='display:none' id='loader'></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <style>
        input.error,
        textarea.error {
            border-color: red;
            margin-bottom: 0;
        }

        label.error {
            position: relative;
        }
    </style>
@endsection @section('script')


    <link rel='stylesheet' href='/front/css/select2.min.css'/>
    <script src="/front/js/select2.min.js"></script>




    <script>
        $('form').validate();
        var ajaxForm = false;
        $(function () {
            $('.ajaxForm_in').submit(function (e) {
                e.preventDefault();
                var loader = $(this).find('#loader');
                if (!$('form').valid()) {
                    return false;
                }
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
                        } else if (data.status == 1) {
                            nofication_good(data.msg);
                            $('.ajaxForm_in .empty').val('');
                            $('#fileList').empty();
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
    </script>
@endsection