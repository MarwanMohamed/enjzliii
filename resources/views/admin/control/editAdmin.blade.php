@extends('admin._layout')

@section('title','الإدارة')
@section('subTitle','تعديل حساب المدير')

@section('content')
    @if(session()->has('msg'))
        <div class="form-group">
            <div class="alert alert-info">{{session()->get('msg')}}</div>
        </div>
    @endif
    <form  method="post" class=" form-horizontal form-bordered" action="/admin/control/editAdmin">
        <input type="hidden" name="id" value="{{$admin->id}}">
		  <div class="form-group">
            <label class="col-sm-3 control-label">الإسم</label>
            <div class="col-sm-6">
                <input type="text" required class="form-control" value="{{$admin->fullname}}" name="fullname"  placeholder="ادخل اسم مدير النظام">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">البريد الإلكتروني</label>
            <div class="col-sm-6">
                <input type="email" disabled value="{{$admin->email}}" class="form-control"  name="email"  placeholder="ادخل البريد الإلكتروني">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">الصلاحية</label>
            <div class="col-sm-6">
            <select name="permission_group" class="select2" style="width: 100%" id="">
                @foreach($groups as $groups)
                    <option {{$groups->id==$admin->permission_group?'selected':''}} value="{{$groups->id}}">{{$groups->name}}</option>
                @endforeach
            </select>
                </div>

        </div>

        {{csrf_field()}}
        <div class=" col-xs-2 col-sm-offset-4">
        <div class="form-group">
            <button type="submit"  class="btn btn-success">حفظ<span class="fa fa-spinner fa-spin hidden " id="my-spinner"></span></button>
        </div>
        </div>
    </form>



@endsection
@section('script')
    <script>
        $('form').validate();
        $('.select2').select2();

    </script>
@endsection