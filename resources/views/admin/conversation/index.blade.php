@extends('admin._layout')
<?php global $setting; ?>
@section('title','المحادثات')
@section('subTitle','عرض')
@section('content')
@if(session()->has('msg'))
<div class="form-group">
    <div class="alert alert-info">{{session()->get('msg')}}</div>
</div>
@endif
<form class="form-inline " action="/admin/conversations">
    <div style="margin-right: 0;" class="form-group">
        <input type="text" class="form-control" value="{{($q)?$q:''}}" name="q" id="exampleInputName2" placeholder="بحث حسب المحادثة او المشروع ">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" value="{{($username)?$username:''}}" name="username" id="exampleInputName2" placeholder="بحث بحسب صاحب المشروع">
    </div>
    <button type="submit" class="btn btn-success">عرض</button>
</form>
<br>
@if(($q))
<div class="col-xs-12 text-center">نتائج البحث </div>
@endif
<style>
    th a {
        width: 100%;
        height: 100%;
        color: #000;
        display: block;
        font-size: 16px;
    }
</style>
<div class="table-responsive">
<table class="table table-striped table-hover">
    <thead>
    <th width="7%">#</th>
    <th>المشروع</th>
    <th>اخر رسالة</th>
    <th>صاحب المشروع</th>
    <th>منجز المشروع</th>
    <th>حالة المشروع</th>
    <th>النوع</th>
    <th></th>
</thead>
<tbody>
    @foreach ($conversations as $key=> $conversation)
    @if(sizeof($conversation->lastMessage))
    <tr>
        <td>{{$conversation->id}}</td>
        <td><a href='/admin/projects/single/{{$conversation->project->id}}'>{{str_limit($conversation->project->title,30)}}</a></td>
        <td>{{str_limit($conversation->lastMessage[0]->content,50)}}</td>
        <td>
            @if($conversation->project->owner)
            <a target="_blank" href="/admin/users/single/{{$conversation->project->owner->id}}">{{$conversation->project->owner->fullname()}}</a>
        @endif</td>
        <td>@if($conversation->freelancer())
            <a target="_blank" href="/admin/users/single/{{$conversation->freelancer()->id}}">{{$conversation->freelancer()->fullname()}}</a>
       @endif </td>
        <td>{{projectStatus($conversation->project,$setting)}}</td>
        <td>{{$conversation->isView == 1 ? 'مقروء' : 'غير مقروء'}}</td>
        <td> 
            @if(checkPerm('single'))<a href="/admin/conversations/single/{{$conversation->id}}" title="عرض" class=" btn btn-success btn-xs">
          <span class="fa fa-arrows-alt"></span></a>
          @endif
            @if((checkPerm('block')||checkPerm('unblock'))&&$conversation->status==1)<a href="/admin/conversations/{{(!$conversation->isBlock)?'block':'unblock'}}/{{$conversation->id}} " title="{{(!$conversation->isBlock)?'حظر':'الغاء الحظر'}}" data-id="{{$conversation->id}}" class="btn btn-warning btn-xs Confirm"><span
                    class="fa fa-eye{{(!$conversation->isBlock)?'-slash':''}}"></span></a>@endif
        </td>
    </tr>
    @endif
    @endforeach
</tbody>
</table>
@if(!sizeof($conversations))
<div style="color:red;text-align: center;font-size: 18px;padding:20px;">لا يوجد بيانات</div>
@endif
</div>
{{$conversations->links()}}
<div id="blockModel" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">سبب الحظر</h4>
            </div>
            <form action="/admin/bids/block" id="blockForm" method="post">
                {{csrf_field()}}
                <div class="modal-body">
                    <p>ادخل سبب الحظر</p>
                    <input type="hidden" name="id" id="bid_id">
                    <div class="form-group"><textarea name="blockReason" class="form-control" rows="7" required maxlength="500" minlength="20"></textarea></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">الغاء</button>
                    <button type="submit" class="btn btn-default" >حظر</button>
                </div>
            </form>
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
            <form action="/admin/bids/cancel" onsubmit="cancelSubmit()" id="cancelForm" method="post">
                {{csrf_field()}}
                <div class="modal-body">  
                    <input type="hidden" name="id" id="bid_id">
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
        $('.block').click(function (e) {
            e.preventDefault();
            $('#blockModel').find('#bid_id').val($(this).data('id'));
            $('#blockModel').modal('show');
            $('#blockForm').validate();
        })
        $('.cancelProject').click(function (e) {
            e.preventDefault();
            $('#cancelModel').find('#bid_id').val($(this).data('id'));
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