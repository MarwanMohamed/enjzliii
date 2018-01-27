@extends('admin._layout')
<?php global $setting;?>
@section('title','الصفحات')
@section('subTitle','عرض')
@section('content')
@if(session()->has('msg'))
    <div class="form-group">
        <div class="alert alert-info">{{session()->get('msg')}}</div>
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
        <th>اسم الصفحة</th>
        <th>تاريخ الانشاء</th>
        <th></th>
        </thead>
        <tbody>
            @foreach($pages as $page)
            <tr>
                <td>{{$page->id}}</td>
                <td>{{$page->title}}</td>
                <td class="date">{{$page->created_at}}</td>
                <td>
                    @if(checkPerm('edit'))
                    <a href="/admin/pages/edit/{{$page->id}}" class="btn btn-xs btn-info"><i class="fa fa-pencil"></i></a>
                    @endif
                </td>
            </tr>
            @endforeach
            <tr>
            </tr>
        </tbody>
    </table>
    @if(!sizeof($pages))
        <div style="color:red;text-align: center;font-size: 18px;padding:15px;">لا يوجد بيانات</div>
    @endif
    </div>
    {{$pages->links()}}
@endsection