<!--/**-->
<!-- * Created by PhpStorm.-->
<!-- * User: abedmq-->
<!-- * Date: 4/10/2017-->
<!-- * Time: 3:40 PM-->
<!-- */-->

@extends('admin._layout')
<?php global $setting;?>

@section('title','حسابات المستخدمين')
@section('subTitle','اعدادات')

@section('content')

    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                @if(session()->has('msg'))
                    <div style="width:100%;">
                        <span class="alert alert-info" style="width:100%;">{{session('msg')}}</span>
                    </div>
                @endif
            </div>

            <form action="/admin/users/setting" method="get">
                {{csrf_field()}}
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">

                                <label class="col-sm-5 control-label">التحكم في التسجيل في الموقع</label>
                                <div class="col-sm-7 control-label">
                                    <div class="toggle1 toggle-success "></div>
                                    <input type="hidden" id="users_isClose" name="users_isClose" value="{{$setting['users_isClose']}}">
                                </div>

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
                        $('.toggle1').toggles({
                            drag: true, // allow dragging the toggle between positions
                            click: true, // allow clicking on the toggle
                            text: {
                                on: 'متاح', // text for the ON position
                                off: 'مغلق' // and off
                            },
                            on: '{{$setting['users_isClose']?false:true}}', // is the toggle ON on init
                            animate: 250, // animation time (ms)
                            easing: 'swing', // animation transition easing function
                            clicker: null, // element that can be clicked on to toggle. removes binding from the toggle itself (use nesting)
                            width: 50, // width used if not set in css
                            height: 20, // height if not set in css
                            type: 'compact' // if this is set to 'select' then the select style toggle will be used
                        });
                        $('.toggle1').on('toggle', function(e, active) {
                            if (active) {
                                $('#users_isClose').val('');
                            } else {
                                $('#users_isClose').val('1');

                            }
                        });
                    </script>
@endsection