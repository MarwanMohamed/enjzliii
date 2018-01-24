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
<form class="form-inline " action="/admin/super/index">
    <div class="form-group">
        <input type="text" class="form-control" value="{{($q)?$q:''}}" name="q" id="exampleInputName2" placeholder="بحث في المشاريع ">
    </div>
    <button type="submit" class="btn btn-success">عرض</button>
</form>
<br>
@if(($q))
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
 <div class="panel panel-default">
  <div class="panel-body">
<div class="table-responsive">
<table class="table table-striped table-hover">
    <thead>
    <th>#</th>
    <th>الاسم</th>
    <th>البريد الإلكتروني</th>
    <th>التخصص</th>
    <th>الميزانية </th>
    <th>تاريخ  الانشاء</th>
    <th>النوع</th>
    <th></th>
</thead>
<tbody>
    @foreach ($requests as $key=> $request)
    <tr>
        <td>{{$request->id}}</td>
        <td>
            {{str_limit($request->fullname,30)}}
        </td>
        <td>{{$request->email}}</td>
        <td>{{isset($request->specialization->name) ? $request->specialization->name : ''}}</td>
        <td>{{$request->budget->fBudget().' دولار'}}</td>
        <td class="date">{{$request->created_at}}</td> 
        <td>{{$request->isView == 1 ? 'مقروء' : 'غير مقروء'}}</td> 
        <td>
            @if(checkPerm('single'))<a href="/admin/super/single/{{$request->id}}" class="btn btn-xs btn-success"><i class="fa fa-eye" ></i></a>@endif
            @if(checkPerm('recieved')) <a href="/admin/super/recieved/{{$request->id}}" class="btn btn-xs btn-info"><i class="fa fa-check"></i></a>@endif
            @if(checkPerm('cancel')) <a href="/admin/super/cancel/{{$request->id}}" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>@endif

        </td>
    </tr>
    @endforeach
</tbody>
</table>
@if(!sizeof($requests))
<div style="color:red;text-align: center;font-size: 18px;padding:15px;">لا يوجد بيانات</div>
@endif
</div>
 </div>
 </div>
{{$requests->links()}}
@endsection