<!--/**-->
<!-- * Created by PhpStorm.-->
<!-- * User: abedmq-->
<!-- * Date: 4/10/2017-->
<!-- * Time: 3:40 PM-->
<!-- */-->

@extends('admin._layout')
<?php global $setting;?>

@section('title','الاعدادت')
@section('subTitle','تغير كلمة المرور')

@section('content')

    <div class="col-md-12">
        <div class="panel panel-default">

            @if(session()->has('msg'))
                <div class="form-group">
                    <span class="alert alert-info">{{session('msg')}}</span>
                </div>
            @endif
            <form action="/admin/accountSetting" method="post">
                {{csrf_field()}}
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-6">
                            {!!textInput('password','','كلمة المرور','password' ,'required min=5 placeholder="ادخل كلمة المرور"')!!}
                            {!!textInput('password_confirmation','',' تأكيد كلمة المرور','password' ,'required min=5 placeholder="ادخل تأكيد كلمة المرور"')!!}
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <button class="btn btn-primary">حفظ</button>
                </div>
            </form>
        </div>
    </div>


@endsection
@section('script')
    <script>

    </script>
@endsection