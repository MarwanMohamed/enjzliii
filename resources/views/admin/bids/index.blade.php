@extends('admin._layout')
<?php global $setting; ?>

@section('title','العروض')
@section('subTitle','عرض')

@section('content')
@if(session()->has('msg'))
<div class="form-group">
    <div class="alert alert-info">{{session()->get('msg')}}</div>
</div>
@endif
<form class="form-inline " action="/admin/bids">

    <div style="margin-right: 0;" class="form-group">
        <input type="text" class="form-control" value="{{($q)?$q:''}}" name="q" id="exampleInputName2"
               placeholder="بحث في العروض ">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" value="{{($owner)?$owner:''}}" name="owner" id="exampleInputName2"
               placeholder="بحث بحسب صاحب العرض ">
    </div>

    <div class="form-group">
        <select name="status" id="" class="form-control ">
            <option value="0" {{$status==0?'selected':''}}>جميع العروض</option>
            <option value="2" {{$status==2?'selected':''}}>مفتوح</option>
            <option value="3" {{$status==3?'selected':''}} >قيد التنفيذ</option>
            <option value="4" {{$status==4?'selected':''}} >ملغي</option>
            <option value="5" {{$status==5?'selected':''}} >مغلق</option>
            <option value="6" {{$status==6?'selected':''}} >منتهي</option>
            <option value="7" {{$status==7?'selected':''}} >محظور</option>
        </select>
    </div>
    <button type="submit" class="btn btn-success">عرض</button>
</form>
<br>
@if(($q))
<div class="col-xs-12 text-center">نتائج البحث عن: <strong style="color:red">{{$q}}</strong></div>
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
    <th><a title="ترتيب حسب رقم المعرف"
           href="/admin/bids?{{$searchParam}}orderBy=id&{{($orderBy=='id'&&$orderByType=='asc')?'desc=1':'asc=1'}}">#</a></th>
    <th> صاحب العرض</th>
    <th>المشروع</th>
    <th>نص العرض</th>
    <th>حالة المشروع</th>
 <th><a title="ترتيب حسب حالة مشروع"
           href="/admin/bids?{{$searchParam}}orderBy=status&{{($orderBy=='status'&&$orderByType=='asc')?'desc=1':'asc=1'}}">حالة
            العرض</a></th>
    <th></th>
</thead>
<tbody>
    @foreach ($bids as $key=> $bid)

    <tr>
        <td>{{$bid->id}}</td>
        <td>
          @if($bid->owner)
          <a target="_blank"
               href="/admin/users/singleUser/{{$bid->owner->id}}">{{$bid->owner->fullname()}}</a>
          @endif
        </td>
        <td><a href='/admin/projects/single/{{$bid->project->id}}'>{{str_limit($bid->project->title,30)}}</a></td>
        <td>{{str_limit($bid->letter,30)}}</td>
        <td>{{projectStatus($bid->project,$setting)}}</td>
        <td>{{bidStatus($bid,$bid->project,$setting)}}</td>
        <td> 
             @if(checkPerm('single'))<a href="/admin/bids/single/{{$bid->id}}" title="عرض" class=" btn btn-success btn-xs"><span
                    class="fa fa-arrows-alt"></span></a>@endif

            @if((checkPerm('block')||checkPerm('unblock'))&&$bid->status==1)<a href="/admin/bids/{{(!$bid->isBlock)?'block':'unblock/'.$bid->id}} " title="{{(!$bid->isBlock)?'حظر':'الغاء الحظر'}}" data-id="{{$bid->id}}" class="btn btn-warning btn-xs {{(!$bid->isBlock)?'block':'Confirm'}}"><span
                    class="fa fa-eye{{(!$bid->isBlock)?'-slash':''}}"></span></a>@endif
        </td>
    </tr>
    @endforeach
</tbody>
</table>
</div>
@if(!sizeof($bids))
<div style="color:red;text-align: center;font-size: 18px">لا يوجد بيانات</div>
@endif

{{$bids->links()}}

<!-- Modal -->
<div id="blockModel" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
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
<!-- Modal -->
<div id="cancelModel" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
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
                        <label>نسبة الأموال المسترجعة لمنجز المشروع </label>
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
            myNoty('الرجاء ادخال رقم صحيح');
        else
            $('#freelancerRate').val(100 - parseInt($(this).val()));
    });


    function cancelSubmit(e, param) {
        e.preventDefault();
        if (param.ownerRate + param.freelancerRate == 100) {
            val = parseInt($('#ownerRate').val());
            if (val < 0 || val > 100)
                myNoty('الرجاء ادخال رقم صحيح');
            else
                $(this).submit();
        } else {
            myNoty('يجب ان يكون مجموع نسبة صاحب المشروع  ومنجز المشروع تساوي100')
        }
    }
</script>
@endsection