@extends('admin._layout')
<?php global $setting;?>

@section('title','الملفات')
@section('subTitle','اضافة')
@section('content')
<style>
  
@media screen and (max-width: 640px) {
form.form-inline.pull-right {
    float: right;
    width: 100%;
    margin-bottom: 20px;
}
}
</style>
    @if(session()->has('msg'))
        <div class="form-group">
            <div class="alert alert-info">{{session()->get('msg')}}</div>
        </div>
    @endif
    <div class="form-group pull-left">
        <a type="text" class="btn btn-success" href="/admin/control/newAdmin" >انشاء مدير نظام</a>
    </div>

    <form class="form-inline pull-right" action="/admin/control/viewAdmin">
        <div class="form-group">
            <input type="text" class="form-control" value="{{($q)?$q:''}}" name="q" id="exampleInputName2" placeholder="بحث..">
        </div>
        <button type="submit" class="btn btn-success">بحث</button>
    </form>
    <br>
<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <th>اسم المدير</th>
            <th>البريد الإلكتروني</th>
            <th>نوع الصلاحية</th>
            <th>تاريخ الإنشاء</th>
            <th>الحالة</th>
            <th></th>
        </thead>
        <tbody>
        @foreach ($admins as $admin)

            <tr>
                <td>{{$admin->fullname}}</td>
                <td>{{$admin->email}}</td>
                <td>{{$admin->group->name}}</td>
                <td dir="ltr" style="text-align:right">{{$admin->created_at}}</td>
                <td>{{($admin->active)?'مفعل':'غير مفعل'}}</td>
                <td>
                    <a href="/admin/control/editAdmin/{{$admin->id}}" title="تعديل" class="btn btn-success btn-xs"><span class="fa fa-pencil"></span></a>
                    <a href="/admin/control/deleteAdmin/{{$admin->id}}" title="حذف" class="Confirm btn btn-danger btn-xs"><span class="fa fa-times"></span></a>
                    <a href="/admin/control/{{($admin->active)?'deActivateAdmin':'activateAdmin'}}/{{$admin->id}}" title="{{($admin->active)?'الغاء التفعيل':'تفعيل'}}" class="btn-info btn btn-xs Confirm"><span class="fa fa-eye-slash "></span></a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @if(!sizeof($admins))
        <div style="color:red;text-align: center;font-size: 18px;padding:15px;">لا يوجد بيانات</div>
    @endif
</div>
    {{$admins->appends(['q'=>$q])->appends(['fillter'=>$q])->links()}}



@endsection
@section('script')

@endsection