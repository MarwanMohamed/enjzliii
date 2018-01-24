@extends('admin._layout')

@section('title','الصلاحيات')
@section('subTitle','عرض')

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
        <a type="text" class="btn btn-success" href="/admin/control/newGroup" >انشاء مجموعة صلاحيات</a>
    </div>

    <form class="form-inline pull-right" action="/admin/control/permission">
        <div class="form-group">
            <input type="text" class="form-control" value="{{($q)?$q:''}}" name="q" id="exampleInputName2" placeholder="بحث..">
        </div>

        <button type="submit" class="btn btn-success">بحث</button>
    </form>
    <br>
<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <th>#</th>
            <th>العنوان</th>
            <th>تاريخ الإنشاء</th>
            <th></th>
        </thead>
        <tbody>
        @foreach ($groups as $key => $group)

            <tr>
                <td>{{$key+1}}</td>
                <td>{{$group->name}}</td>
                <td dir="ltr" style="text-align:right">{{$group->created_at}}</td>
                <td>
                    @if($group->id!=1)
                        <a href="/admin/control/editGroup/{{$group->id}}" title="تعديل" class=" btn btn-success btn-xs"><span class="fa fa-pencil"></span></a>
                        <a href="/admin/control/deleteGroup/{{$group->id}}" title="حذف" class="Confirm btn btn-danger btn-xs"><span class="fa fa-times"></span></a>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @if(!sizeof($groups))
        <div style="color:red;text-align: center;font-size: 18px;padding:15px;">لا يوجد بيانات</div>
    @endif
</div>
    {{$groups->appends(['q'=>$q])->appends(['fillter'=>$q])->links()}}



@endsection
@section('script')

@endsection