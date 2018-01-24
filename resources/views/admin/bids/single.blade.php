<!--/**-->
<!-- * Created by PhpStorm.-->
<!-- * User: abedmq-->
<!-- * Date: 4/10/2017-->
<!-- * Time: 3:40 PM-->
<!-- */-->

@extends('admin._layout')
<?php global $setting; ?>
@section('title','حسابات المستخدمين')
@section('subTitle','عرض المشروع')
@section('content')
<style>
    .activity-list .act-thumb{
        width: 128px;
    }
</style>
<div class="contentpanel">
    <div class="row">
        <div class="col-sm-3">
          <div class="panel panel-default">
            <div class="panel-body">
            <img style="width: 140px;" src="{{$bid->owner->avatar()}}" class="thumbnail img-responsive" alt=""/>
            <div class="mb30"></div>
            <h5 class="subtitle">صاحب العرض</h5>
            <address style="line-height: 24px;font-size: 14px;" class='address_sub'>
                <span>اسم المستخدم :</span>{{$bid->owner->fullname()}}<br>
                <span>البريد الإلكتروني :</span> {{$bid->owner->email}} <br>
                <span>الملف الشخصي :</span> {{$bid->owner->isFinishProfile?'جاهز':'غير جاهز'}} <br>
            </address>
        </div>
        </div>
        </div>
        <div class="col-sm-9">
          <div class="panel panel-default">
            <div class="panel-body">
            <div class="profile-header">
                <h2>العرض </h2>
                <p>{{$bid->letter}}</p>
                <div class="table-responsive">
                <table style="border: solid 1px #efefef;" class="table">
                    <tr>
                        <td>المدة</td>
                        <td>{{$bid->deliveryDuration }} يوم</td>
                    </tr>
                    <tr>
                        <td>التكلفة</td>
                        <td>{{$bid->cost }} دولار</td>
                    </tr>
                    <tr>
                        <td>حالة المشروع</td>
                        <td>{{projectStatus($bid->project,$setting)}}</td>
                    </tr>
                    <tr>
                        <td>حالة العرض</td>
                        <td>{{bidStatus($bid,$bid->project,$setting)}}</td>
                    </tr>
                     @if($bid->isBlock)
                    <tr>
                        <td colspan="2">هذا العرض محظور لالغاء الحظر  @if(checkPerm('unblock'))<a href='/admin/bids/unblock/{{$bid->id}}'>اضغط هنا</a>@endif</td>
                    </tr>
                    <tr>
                        <td>سبب الحظر</td>
                        <td>{{$bid->blockReason}}</td>
                    </tr>
                    @endif
                </table>
              </div>
                <div class="clearfix"></div>

                <div class="profile-position ">
                    <h2>تفاصيل المشروع</h2>
                    <p> {{$bid->project->description}}</p></div>
                <div class="profile-position ">
                    @if(sizeof($bid->file ))
                    <h1>الملفات المرفقة</h1>
                    @foreach($bid->file as $file)
                    <a href="/download/{{$file->id}}" class="attachment" ><i class="fa fa-file"></i>{{$file->orginName}}<span></span></a>
                    @endforeach
                    @endif
                </div>
                <div class="mb20"></div>
                <a class="btn btn-success" href='/admin/projects/single/{{$bid->project->id}}'>عروض المشروع</a>
                <button class="btn btn-success mr5 hidden"><i class="fa fa-user"></i> Follow</button>
                <button class="btn btn-white hidden"><i class="fa fa-envelope-o"></i> Message</button>
            </div><!-- profile-header -->
        </div><!-- col-sm-9 -->
              </div><!-- col-sm-9 -->        
</div><!-- col-sm-9 -->
    </div><!-- row -->
</div><!-- contentpanel -->
@endsection
@section('script')
<script>
</script>
@endsection