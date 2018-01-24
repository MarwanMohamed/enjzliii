<!--/**-->
<!-- * Created by PhpStorm.-->
<!-- * User: abedmq-->
<!-- * Date: 4/10/2017-->
<!-- * Time: 3:40 PM-->
<!-- */-->

@extends('admin._layout')
<?php global $setting;?>

@section('title','الملفات')
@section('subTitle','اضافة')

@section('content')

    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-btns">
                    <a href="" class="panel-close">&times;</a>
                    <a href="" class="minimize">&minus;</a>
                </div>
                <h4 class="panel-title">اضافة امتداد جديد</h4>
            </div>
            @if(session()->has('msg'))
                <div class="form-group">
                    <span class="alert alert-info">{{session('msg')}}</span>
                </div>
            @endif
            <form action="/admin/files/add" method="post">
                {{csrf_field()}}
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>النوع</label>
                                <input name="mime" required="" class="form-control" />
                            </div>
                            
                            <div class="form-group">
                                <label>الإمتداد</label>
                                <input name="extension" required="" class="form-control" />
                            </div>
                            
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
        $('form').validate();
    </script>
@endsection