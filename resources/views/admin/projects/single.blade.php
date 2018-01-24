@extends('admin._layout')
<?php global $setting; ?>

@section('title','المشاريع')
@section('subTitle','عرض المشروع')

@section('content')

<style>
    .activity-list .act-thumb{
        width: 128px;
    }
  .btn-j-ok{
        width: 100%;
    display: inline-block;
  }
</style>
<div class="contentpanel">
    <div class="row">
        <div class="col-sm-3">
           <div class="panel panel-default">
            <div class="panel-body">
            <img style="width: 140px;" src="{{$project->owner->avatar()}}" class="thumbnail img-responsive" alt=""/>
            <div class="mb30"></div>
            <h5 class="subtitle">صاحب المشروع</h5>
            <address style="line-height: 24px;font-size: 14px;" class='address_sub'>
                <span>اسم المستخدم :</span>{{$project->owner->fullname()}}<br>
                <span>البريد الإلكتروني :</span> {{$project->owner->email}} <br>
                <span>الملف الشخصي :</span> {{$project->owner->isFinishProfile?'جاهز':'غير جاهز'}} <br>
            </address>
              </div>
          </div>
        </div>
        <div class="col-sm-9">
           <div class="panel panel-default">
            <div class="panel-body">
            <h2 class="profile-name">{{$project->title}}</h2>
            <div class="profile-header">
              <div class="table-responsive">
                <table class="table">
                    <tr>
                        <td>المدة</td>
                        <td>{{$project->deliveryDuration }} يوم</td>
                    </tr>
                    <tr>
                        <td>الميزانية</td>
                        <td>{{$cost->cost or $project->budget->fBudget() }} دولار</td>
                    </tr>
                    <tr>
                        <td>التخصص</td>
                        <td>{{($project->specialization)?$project->specialization->name:'' }}</td>
                    </tr>
                    <tr>
                        <td>حالة المشروع</td>
                        <td>{{projectStatus($project,$setting)}}</td>
                    </tr>
                    @if($project->status!=1)
                    <tr>
                        <td>عدد العروض</td>
                        <td class='tdBtn'>{{$project->bids_count}}  <a class="btn btn-success pull-right" href='/admin/bids/index/{{$project->id}}'>جميع العروض </a></td>
                    </tr>
                    @endif
                    @if($project->isVIP)
                    <tr>
                        <td colspan="2">هذا المشروع مدار من قبل vip</td>
                    </tr>
                    <tr>
                        <td>المدير المشرف على المشروع</td>
                        <td>{{$project->VIP->fullname()}}</td>
                    </tr>
                    @endif
                    
                    @if($project->status==3)
                    <tr>
                        <td>المنفذ</td>
                        <td>{{$project->freelancer[0]->user->username?$project->freelancer[0]->user->username:$project->freelancer[0]->user->fullname()}}</td>
                    </tr>
                    <tr>
                        <td>استلام المشروع</td>
                        <td>مضى عليه  {{getDay($project->freelancer[0]->created_at)}} يوم</td>
                    </tr>

                    <tr>
                        <td>الفترة المتفق عليها </td>
                        <td>{{($project->freelancer[0]->deliveryDuration)}} يوم</td>
                    </tr>
                        <tr>
                        <td>المبلغ المتفق عليه </td>
                        <td>{{($project->freelancer[0]->cost)}} $</td>
                    </tr>

                    @endif
                </table>
              </div>
                <div class="clearfix"></div>

                <div class="profile-position ">
                    <h2>تفاصيل المشروع</h2>
                    <p> {{$project->description}}</p>
                </div>
                <div class="clearfix"></div>
                <div class="profile-position ">

                    <h2>سبب الالغاء</h2>
                    @if(isset($project->caneclProject->reason))
                    <p> {{$project->caneclProject->reason}}</p>
                    @endif
                </div>


                <div class="profile-position ">
                    @if(sizeof($project->file ))
                    <h1>الملفات المرفقة</h1>
                    @foreach($project->file as $file)
                    <a href="/download/{{$file->id}}" class="attachment" ><i class="fa fa-file"></i>{{$file->orginName}}<span></span></a>
                    @endforeach
                    @endif
                </div>
                <div class="mb20"></div>
                @if(checkPerm('approve')&&$project->status==1)<a class="btn btn-info btn-j-ok" href='/admin/projects/approve/{{$project->id}}'>الموافقة على المشروع</a>@endif
            </div><!-- profile-header -->
        </div><!-- col-sm-9 -->
      </div>
      </div>
    </div><!-- row -->

</div><!-- contentpanel -->



@endsection
@section('script')
<script>

</script>
@endsection