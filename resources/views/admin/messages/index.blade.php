@extends('admin._layout')
<?php global $setting;?>
@section('title','رسائل المستخدمين')
@section('subTitle','عرض')
@section('content')
    @if(session()->has('msg'))
        <div class="form-group">
            <div class="alert alert-info">{{session()->get('msg')}}</div>
        </div>
    @endif
    <form class="form-inline " action="/admin/messages/index">
        <div style="margin-right: 0;" class="form-group">
            <input type="text" class="form-control" value="{{($q)?$q:''}}" name="q" id="exampleInputName2" placeholder="بحث..">
        </div>
        <div class="form-group">
            {{Form::select('type',$tibs,$type?$type:0,['class'=>'form-control'])}}
        </div>
        <button type="submit" class="btn btn-success">بحث</button>
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
        <th>#</th>
        <th width='15%'>نوع المشكلة</th>
        <th width='50%'>العنوان</th>
        <th>تاريخ الانشاء</th>
        <th>النوع</th>
        <th width='80px'></th>
        </thead>
        <tbody>
            @foreach($messages as $message)
            <tr>
                <td>{{$message->id}}</td>
                <td>{{$message->problem->value}}</td>
                <td>{{$message->title}}</td>
                <td class='date'>{{$message->created_at}}</td>
                <td>{{$message->isView == 1 ? 'مقروء' : 'غير مقروء'}}</td>
                <td>
                    @if(checkPerm('single'))
                    <a href="/admin/messages/single/{{$message->id}}" class="btn btn-success btn-xs "><i class="fa fa-arrows-alt"></i></a>
                    
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @if(!sizeof($messages))
        <div style="color:red;text-align: center;font-size: 18px;padding:20px;">لا يوجد بيانات</div>
    @endif
    {{$messages->appends(['q'=>$q])->links()}}
</div>
@endsection