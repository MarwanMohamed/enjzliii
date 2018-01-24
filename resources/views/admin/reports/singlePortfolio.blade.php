@extends('admin._layout')
<?php global $setting; ?>
@section('title','التبليغات')
@section('subTitle','عرض العمل')
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
            <img style="width: 140px;" src="{{$portfolio->owner->avatar()}}" class="thumbnail img-responsive" alt=""/>
            <div class="mb30"></div>
            <h5 class="subtitle">صاحب العمل</h5>
            <address style="line-height: 24px;font-size: 14px;" class='address_sub'>
                <span>اسم المستخدم : <a href="/admin/users/single/{{$portfolio->owner->id}}">{{$portfolio->owner->username?$portfolio->owner->username:'غير مدخل'}}</a></span><br>
                <span>البريد الإلكتروني :</span> {{$portfolio->owner->email}} <br>
                <span>الملف الشخصي :</span> {{$portfolio->owner->isFinishProfile?'جاهز':'غير جاهز'}}<br>
            </address>
        </div>
        </div>
        </div>
        <div class="col-sm-9">
            <div class="panel panel-default">
            <div class="panel-body">
            <div class="profile-header">
                <h2 class=""><strong>العنوان :</strong>
                {{$portfolio->title}}</h2>
                <h4>تفاصيل العمل</h4>
                <div class="table-responsive">
                <table class="table" style="text-align: right">
                    <tr>
                        <td>حالة العمل</td>
                        <td>{{$portfolio->status()}}</td>
                    </tr>
                    <tr>
                        <td>عدد التبليغات</td>
                        <td>{{$portfolio->reports->count()}}</td>
                    </tr>
                    <tr>
                        <td>الإعجاب</td>
                        <td>{{$portfolio->likes->count()}}</td>
                    </tr>
                    <tr>
                        <td>المشاهدات</td>
                        <td>{{$portfolio->views->count()}}</td>
                    </tr>
                    <tr>
                        <td>التفضيلات</td>
                        <td>{{$portfolio->favorites->count()}}</td>
                    </tr>
                    @if(checkPerm('blockPortfolio')||checkPerm('unblockPortfolio'))
                    <tr>
                        <td colspan="2" > 
                            @if(!$portfolio->isBlock)
                            <a href='/admin/reports/blockPortfolio/{{$portfolio->id}}' class="btn btn-danger">حظر</a>
                            @else
                            <a href='/admin/reports/unblockPortfolio/{{$portfolio->id}}' class="btn btn-success">الغاء الحظر</a>
                            @endif
                        </td>
                    </tr>
                    @endif
                </table>
              </div>
                <div class="clearfix"></div>
                <div class="profile-position ">
                    <h4>تفاصيل التبليغات</h4> 
                    <?php $reports = $portfolio->reports; ?>
                    @foreach($reports as $report)
                    <div class='report'>
                        <img width="50" height="50" src="{{$report->owner->avatar()}}"/>
                        <a href="/admin/users/single/{{$report->owner->id}}"><h4 class="fullname">{{$report->owner->fullname()}}</h4></a>
                        <span class="content">{{$report->reportreason->value}}</span>
                        <span class="status" style="    margin: 22px;">{{$report->status?'تم الحل':'قيد التنفيذ'}}</span>
                    </div>
                    @endforeach
                    <div class="mb20"></div>
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
                <form action="/admin/portfolios/cancel" onsubmit="cancelSubmit()" id="cancelForm" method="post">
                    {{csrf_field()}}
                    <div class="modal-body">
                        <input type="hidden" name="id" id="portfolio_id">
                        <div class="form-group">
                            <label>سبب الالغاء</label>
                            <textarea name="blockReason" class="form-control" rows="7" maxlength="500" minlength="20"></textarea></div>
                        <div class="form-group hideIf" id="">
                            <label>نسبة الأموال المسترجعة لصاحب العمل</label>
                            <input id="ownerRate" type="number" class="form-control" name="ownerRate" placeholder="ادخل النسبة من 100"/>
                        </div>
                        <div class="form-group hideIf">
                            <label>نسبة الأموال المسترجعةلمنفذ العمل </label>
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
                $('#cancelModel').find('#portfolio_id').val($(this).data('id'));
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
                myNoty('يجب ان مجموع نسبة صاحب العمل ومنفذ العمل تساوي100')
            }
        }
    </script>
    @endsection