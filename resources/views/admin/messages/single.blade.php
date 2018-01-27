<!--/**-->
<!-- * Created by PhpStorm.-->
<!-- * User: abedmq-->
<!-- * Date: 4/10/2017-->
<!-- * Time: 3:40 PM-->
<!-- */-->

@extends('admin._layout')
<?php global $setting;?>

@section('title','رسائل المستخدمين')
@section('subTitle','عرض')

@section('content')

    <div class="col-md-12">
        <div class="panel panel-default">

            @if(session()->has('msg'))
                <div class="form-group">
                    <span class="alert alert-info">{{session('msg')}}</span>
                </div>
            @endif
            
<div class="table-responsive">
            <table class="table">
                <tr>
                    <td width='30%'>البريد الإلكتروني</td>
                    <td>{{$message->email}}</td>
                </tr>
                <tr>
                    <td>نوع الرسالة</td>
                    <td>{{$message->problem->value}}</td>
                </tr>
                <tr>
                    <td>العنوان</td>
                    <td>{{$message->title}}</td>
                </tr>
                <tr>
                    <td>نص الرسالة</td>
                    <td>{{$message->message}}</td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: left">
                        <a class="btn btn-info" href='{{url()->previous()}}'>رجوع</a>
                    </td>
                </tr>
            </table>
        </div>
        </div>
    </div>


@endsection
@section('script')
    <script>

    </script>
@endsection