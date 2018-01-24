@extends('admin._layout')
<?php global $setting; ?>

@section('title','الدفعات المالية')
@section('subTitle','طلبات سحب الرصيد')

@section('content')
@if(session()->has('msg'))
<div class="form-group">
    <div class="alert alert-info">{{session()->get('msg')}}</div>
</div>
@endif
@if(session()->has('error'))
<div class="form-group">
    <div class="alert alert-info">{{session()->get('error')}}</div>
</div>
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
    <th>#</th>
    <th>اسم المستخدم</th>
    <th>الاسم كاملا</th>
    <th>المبلغ المراد سحبه</th>
    <th>paypal email</th>
    <th>الرصيد المتاح سحبه</th>
    <th></th>
</thead>
<tbody>
    @foreach ($withdraws as $key=> $withdraw)
    <tr>
        <td>{{$withdraw->id}}</td>

        <td>
            <a href='/admin/users/single/{{$withdraw->user?$withdraw->user->id:''}}'>{{str_limit($withdraw->user?$withdraw->user->username:0,30)}}</a>
        </td>
        <td><a href='/admin/users/single/{{$withdraw->user?$withdraw->user->id:''}}'>{{($withdraw->user?$withdraw->user->fullname():'')}}</a></td>
        <td>
            {{$withdraw->amount}}
        </td>
        <td >{{$withdraw->paypalEmail}}</td> 
        <td>{{$withdraw->user?$withdraw->user->balance:0-$withdraw->user?$withdraw->user->suspended_balance:0}}</td>
        <td>
            @if(checkPerm('withdraw'))
            <a  data-paypal='{{$withdraw->paypalEmail}}' data-withdrawid='{{$withdraw->id}}' data-amount='{{$withdraw->amount}}' class="btn btn-success transfer">تحويل</a>
            @endif
        </td>
    </tr>
    @endforeach
</tbody>
</table>
@if(!sizeof($withdraws))
<div style="color:red;text-align: center;font-size: 18px;padding:15px;">لا يوجد بيانات</div>
@endif
</div>

<!-- Modal -->
<div id="withdrawModal" data-backdrop="static" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">تحويل الرصيد</h4>
            </div>
            <form action="/admin/addmoney/payout" method="post"/>
            <div class="modal-body">

                <div class="form-group">
                    <label class="col-sm-4 control-label">المبلغ المراد سحبه:</label>
                    <div class="col-sm-8">
                        <input type="text" disabled="" id="amountA" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label">paypal email</label>
                    <div class="col-sm-8">
                        <input type="email" disabled="" id="paypalEmail" class="form-control">
                    </div>
                </div>

                <input name="id" type="hidden" value="" id="withdrawid"/>
                {{csrf_field()}}
            </div>
            <div class="modal-footer">
                <button type="submit" class='btn btn-success' >تحويل</button>

                <button type="button" class="btn btn-default" data-dismiss="modal">رجوع</button>
            </div>
            
        </form>
        </div>

    </div>
</div>

{{$withdraws->links()}}



@endsection

@section('script')
<script>
    $(function () {
        $('.transfer').click(function () {
            $('#amountA').val($(this).data('amount')+' دولار');
            $('#paypalEmail').val($(this).data('paypal'));
            $('#withdrawid').val($(this).data('withdrawid'));
            $('#withdrawModal').modal('show');
            
        });
    });
</script>
@endsection
