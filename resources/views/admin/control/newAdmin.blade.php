@extends('admin._layout')

@section('title','الإدارة')
@section('subTitle','مدير جديد')

@section('content')
    @if(session()->has('msg'))
        <div class="form-group">
            <div class="alert alert-info">{{session()->get('msg')}}</div>
        </div>
    @endif
    <form  method="post" class=" form-horizontal form-bordered" action="/admin/control/newAdmin">
        
		  <div class="form-group">
            <label class="col-sm-3 control-label" >الإسم</label>
            <div class="col-sm-6">
                <input type="text" required class="form-control" value="{{old('fullname')}}"  name="fullname"  placeholder="ادخل اسم مدير النظام">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">البريد الإلكتروني</label>
            <div class="col-sm-6">
                <input type="email" required class="form-control"   value="{{old('email')}}" name="email"  placeholder="ادخل البريد الإلكتروني">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">الصلاحية</label>
            <div class="col-sm-6">
            <select name="permission_group" class="select2" style="width: 100%" id="">
                @foreach($groups as $groups)
                    <option value="{{$groups->id}}">{{$groups->name}}</option>
                @endforeach
            </select>
                </div>

        </div>

        {{csrf_field()}}
        <div class=" col-xs-2 col-sm-offset-4p">
        <div class="form-group">
            <button type="submit"  class="btn btn-success">اضافة<span class="fa fa-spinner fa-spin hidden " id="my-spinner"></span></button>
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