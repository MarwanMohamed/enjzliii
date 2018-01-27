@extends('admin._layout')
<?php global $setting; ?>

@section('title','الدفعات المالية')
@section('subTitle','عرض')

@section('content')
@if(session()->has('msg'))
<div class="form-group">
    <div class="alert alert-info">{{session()->get('msg')}}</div>
</div>
@endif
@if(isset($q))
<form class="form-inline " action="/admin/transactions/index">

    <div class="form-group">
        <input type="text" class="form-control" value="{{($q)?$q:''}}" name="q" id="exampleInputName2"
               placeholder="بحث في المستقبل او المرسل ">
    </div>
    <div class="form-group">
        <select name="type" class="form-control">
            <option value="0" >الكل</option>
            <option value="1" {{$type == 1?'selected':''}}>صادر من الموقع</option>
            <option value="2" {{$type == 2?'selected':''}}>وارد للموقع</option>
            <option value="3" {{$type == 3?'selected':''}}>تحويلات المستخدمين</option>
        </select>
    </div>

    <button type="submit" class="btn btn-success">عرض</button>
</form>
@else
<div>
    <h4>تفاصيل المستخدم</h4>
<div class="table-responsive">
    <table class="table">
        <tr>
            <td>الاسم كاملا</td>
            <td>{{$user->fullname()}}</td>
        </tr>
        <tr>
            <td>اسم المستخدم </td>
            <td>{{$user->username}}</td>
        </tr>

        <tr>
            <td>البريد الإلكتروني </td>
            <td>{{$user->email}}</td>
        </tr>

        <tr>
            <td>الرصيد الكلي</td>
            <td>{{$user->balance}} دولار</td>
        </tr>
        <tr>
            <td>الرصيد المعلق</td>
            <td>{{$user->suspended_balance}} دولار</td>
        </tr>
        <tr>
            <td>التحويلات الصادرة</td>
            <td>{{$user->transactionSent->sum('amount_send')}} دولار</td>
        </tr>
      
        <tr>
            <td>التحويلات الواردة</td>
            <td>{{$user->transactionRecieved->sum('amount_recieve')}} دولار</td>
        </tr>
      
    </table>
  </div>
</div>
@endif
<br>
@if(isset($q))
<div class="col-xs-12 text-center" style="padding:15px;">نتائج البحث عن: <strong style="color:red">{{$q}}</strong></div>
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
    <h4>تفاصبل الحوالات المالية</h4>

<div class="table-responsive">
<table class="table table-striped table-hover">
    <thead>
    <th>#</th>
    <th>المستقبل</th>
    <th>نوع الحوالة</th>
    <th>المرسل</th>
    <th>تاريخ الحوالة</th>
    <th>المبلغ</th>
    <th>المبلغ العائد للموقع</th>
    <th></th>
</thead>
<tbody>
    @foreach ($transactions as $key=> $transaction)
    <tr>
        <td>{{$key+1}}</td>


        <td>@if(isset($transaction->reciever_id) && $transaction->reciever_id != 0)
            <a href='/admin/transactions/user/{{ $transaction->reciever->id }}'>{{str_limit($transaction->reciever->username,30)}}</a>
            @else
            <span>موقع انجزلي</span>
            @endif

        </td>
        <td>{{($transaction->process_type==1)?'صادر من الموقع':(($transaction->process_type==2)?'وارد للموقع':'تحويلات مستخدمين')}}</td>
        <td>
            @if($transaction->sender)
            <a target="_blank"
               href="/admin/transactions/user/{{$transaction->sender->id}}">{{$transaction->sender->fullname()}}
            </a>
            @else
                @if($transaction->process_type==2)
                    <span>{{$transaction->transaction_type==1?'باى بال':'فيزا'}}</span>
                    @else
            <span>موقع انجزلي</span>
                @endif
            @endif</td>
        <td class="date">{{$transaction->created_at}}</td> 
        <td>{{$transaction->amount_send}}</td>
        <td>{{$transaction->process_type==1?0:$transaction->amount_send-$transaction->amount_recieve}}</td>
    </tr>
    @endforeach
</tbody>
</table>
@if(!sizeof($transactions))
<div style="color:red;text-align: center;font-size: 18px;padding:15px;">لا يوجد بيانات</div>
@endif
</div>

{{$transactions->links()}}



@endsection
