@extends('admin._layout')
<?php global $setting; ?>
@section('title','التبليغات')
@section('subTitle','عرض المشروع')
@section('content')
<style>
    .activity-list .act-thumb{
        width: 128px;
    }
    .activity-list .act-thumb{
        width: 128px;
    }
    h4.fullname {
        display: inline-block;
    }
    span.content {
        display: block;
        font-size: 17px;
        margin: 21px;
    }
</style>
<div class="contentpanel">
    @if(session()->has('msg'))
    <div class="form-group">
        <div class="alert alert-info">{{session()->get('msg')}}</div>
    </div>
    @endif
    <div class="row">
        <div class="col-sm-3">
          <div class="panel panel-default">
            <div class="panel-body">
            <img style="width: 140px;" src="{{$project->owner->avatar() }}" class="thumbnail img-responsive" alt=""/>
            <div class="mb30"></div>
            <h5 class="subtitle">صاحب المشروع</h5>
            <address style="line-height: 24px;font-size: 14px;" class='address_sub'>
                <span>اسم المستخدم :<a href="/admin/users/single/{{$project->owner->id}}"> {{$project->owner->username?$project->owner->username:'غير مدخل'}}</a></span><br>
                 <span>البريد الإلكتروني : </span> {{$project->owner->email}} <br>
                 <span>الملف الشخصي :</span> {{$project->owner->isFinishProfile?'جاهز':'غير جاهز'}}<br>
            </address>
        </div>
         </div>
          </div>
        <div class="col-sm-9">
          <div class="panel panel-default">
            <div class="panel-body">
            <div class="profile-header">
                <h2 class=""><strong>العنوان :</strong>
                    <a href="/admin/projects/single/{{$project->id}}">{{$project->title}}</a></h2>
                <h4>تفاصيل المشروع</h4>

              <div class="table-responsive">
                <table class="table" style="text-align: right">
                    <tr>
                        <td>عدد الأيام</td>
                        <td>{{$project->deliveryDuration }}</td>
                    </tr>
                    <tr>
                        <td>ميزانية المشروع</td>
                        <td>{{$project->budget->fBudget() }}</td>
                    </tr>
                    <tr>
                        <td>تصنيف المشروع</td>
                        <td>{{($project->specialization)?$project->specialization->name:'' }}</td>
                    </tr>
                    <tr>
                        <td>حالة المشروع</td>
                        <td>{{projectStatus($project,$setting)}}</td>
                    </tr>
                    <tr>
                        <td>عدد العروض</td>
                        <td>{{$project->bids->count()}}</td>
                    </tr>
                    <tr>
                        <td>عدد التبليغات</td>
                        <td>{{$project->reports->count()}}</td>
                    </tr>
                    @if($project->status==3)
                    <tr>
                        <td>المنفذ</td>
                        <td>{{$project->freelancer[0]->user->username?$project->freelancer[0]->user->username:$project->freelancer[0]->user->fullname()}}</td>
                    </tr>

                    <tr>
                        <td>استلام المشروع</td>
                        <td> قبل {{getDay($project->freelancer[0]->created_at)}} يوم</td>
                    </tr>

                    <tr>
                        <td>الفترة المتفق عليها</td>
                        <td>{{($project->freelancer[0]->deliveryDuration)}} يوم</td>
                    </tr>
                    <tr>
                        <td colspan="2" > 
                            <a href="javascript:;" data-id='{{$project->id}}' data-status={{$project->status}} class="cancelProject btn btn-danger" >الغاء المشروع</a>
                        </td>
                    </tr>
                    @endif
                </table>
              </div>
                <div class="profile-position ">
                    <h4>تفاصيل التبليغات</h4> 
                    <?php $reports = $project->reports; ?>
                    @foreach($reports as $report)
                    <div class= 'report'>
                        <img width="50" height="50" src="{{$report->owner->avatar()}}"/>
                        <a href="/admin/users/single/{{$report->owner->id}}"><h4 class="fullname">{{$report->owner->fullname()}}</h4></a>
                        <span class="content">{{$report->reportreason->value}}</span>
                        <span class="status" style="    margin: 22px;">{{$report->status?'تم الحل':'قيد التنفيذ'}}</span>
                    </div>
                    @endforeach
                    <div class="mb20"></div>
                   @if(checkPerm('blockProject')||checkPerm('unblockProject'))
                    <tr>
                        <td colspan="2" > 
                            @if(!$project->isBlock)
                              <a href='/admin/reports/blockProject/{{$project->id}}' class="btn btn-danger">حظر</a>
                            @endif
                        </td>
                    </tr>
                    @endif
                </div>
            </div>
        </div>
        </div>
        </div>
    </div>
    <div id="cancelModel" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">سبب الحظر</h4>
                </div>
                <form action="/admin/projects/cancel" onsubmit="cancelSubmit()" id="cancelForm" method="post">
                    {{csrf_field()}}
                    <div class="modal-body">
                        <input type="hidden" name="id" id="project_id">
                        <div class="form-group">
                            <label>سبب الالغاء</label>
                            <textarea name="blockReason" class="form-control" rows="7" maxlength="500" minlength="20"></textarea></div>
                        <div class="form-group hideIf" id="">
                            <label>نسبة الأموال المسترجعة لصاحب المشروع</label>
                            <input id="ownerRate" type="number" class="form-control" name="ownerRate" placeholder="ادخل النسبة من 100"/>
                        </div>
                        <div class="form-group hideIf">
                            <label>نسبة الأموال المسترجعةلمنفذ المشروع </label>
                            <input id="freelancerRate" class="form-control" disabled type="integer" name="freelancerRate" placeholder="ادخل النسبة من 100"/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-default" >حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endsection
    @section('script')
    <script>
        $(function () {
            $('.cancelProject').click(function (e) {
                e.preventDefault();
                $('#cancelModel').find('#project_id').val($(this).data('id'));
                if (parseInt($(this).data('status')) != 3) {
                    $('.hideIf').addClass('hidden');
                }
                $('#cancelModel').modal('show');
                $('#cancelForm').validate();

            })
        });
        $('body').on('keyup', '#ownerRate', function () {
            val = parseInt($(this).val());
            if (val < 0 || val > 100)
                myNoty('الرجاء ادخل رقم صحيح');
            else
                $('#freelancerRate').val(100 - parseInt($(this).val()));
        });
        function cancelSubmit(e, param) {
            e.preventDefault();
            if (param.ownerRate + param.freelancerRate == 100) {
                val = parseInt($('#ownerRate').val());
                if (val < 0 || val > 100)
                    myNoty('الرجاء ادخل رقم صحيح');
                else
                    $(this).submit();
            } else {
                myNoty('يجب ان مجموع نسبة صاحب المشروع ومنفذ المشروع تساوي100')
            }
        }
    </script>
    @endsection