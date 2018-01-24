<!--/**-->
<!-- * Created by PhpStorm.-->
<!-- * User: abedmq-->
<!-- * Date: 4/10/2017-->
<!-- * Time: 3:40 PM-->
<!-- */-->

@extends('admin._layout')
<?php global $setting;?>

@section('title','حسابات المستخدمين')
@section('subTitle','اضافة')

@section('content')


    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-btns">
                    <a href="" class="panel-close">&times;</a>
                    <a href="" class="minimize">&minus;</a>
                </div>
                <h4 class="panel-title">اضافة مستخدم جديد</h4>
            </div>
            <form action="/admin/users/add" method="post">
                {{csrf_field()}}
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label">الاسم الأول</label>
                            <input type="text" name="fname" value="{{old('fname')}}"  class="form-control" />
                        </div>
                    </div><!-- col-sm-6 -->
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label">الاسم الأخير</label>
                            <input type="text" name="lname" value="{{old('lname')}}"  class="form-control" />
                        </div>
                    </div><!-- col-sm-6 -->
                </div><!-- row -->

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label">البريد الإلكتروني</label>
                            <input type="email" name="email" value="{{old('email')}}" class="form-control" />
                        </div>
                    </div><!-- col-sm-6 -->
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label">الدولة</label>

                            {!! Form::select('country_id', $countries->pluck('name','id'), old('country_id'), array('class' => 'form-control ')) !!}
                        </div>
                    </div><!-- col-sm-6 -->
                </div><!-- row -->

            </div><!-- panel-body -->
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