@extends('admin._layout')
<?php global $setting; ?>

@section('title','طلبات مشاريع super')
@section('subTitle','عرض')

@section('content')
@if(session()->has('msg'))
<div class="form-group">
    <div class="alert alert-info">{{session()->get('msg')}}</div>
</div>
@endif


<div class="table-responsive">
<table class="table">
    <tr>
        <td width='25%'>اسم مقدم الطلب</td>
        <td>{{$request->fullname}}</td>
    </tr>
    <tr>
        <td>البريد الإلكتروني</td>
        <td>{{$request->email}}</td>
    </tr>
    <tr>
        <td>التخصص</td>
        <td>{{isset($request->specialization->name) ? $request->specialization->name : ''}}</td>
    </tr>
    <tr>
        <td>الميزانية</td>
        <td>{{$request->budget->fBudget()}} دولار</td>
    </tr>
    <tr>
        <td>التفاصيل</td>
        <td>{{$request->details}}</td>
    </tr>
    <tr>
        <td>الحالة</td>
        <td>{{$request->status()}}</td>
    </tr>
    <tr>
        <td></td>
        <td>
            @if(checkPerm('recieved')) <a href="/admin/super/recieved/{{$request->id}}" class="btn btn-info"><i class="fa fa-check"></i></a>@endif
            @if(checkPerm('cancel')) <a href="/admin/super/cancel/{{$request->id}}" class="btn btn-danger"><i class="fa fa-times"></i></a>@endif
        </td>
    </tr>
</table>
</div>
@endsection
