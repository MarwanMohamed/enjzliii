@extends('admin._layout')
<?php global $setting;?>
@section('title','الصور الافتراضية')
@section('subTitle','عرض ')
@section('content')
    <style>
        .activity-list .act-thumb {
            width: 128px;
        }
    </style>
 <div class="panel panel-default">
  <div class="panel-body">
    <div class="contentpanel">
        @if(session('msg'))
        <div class="form-group">
            <div class="alert alert-info">{{session('msg')}}</div>
        </div>
        @endif
        <form action="/admin/control/usersImages" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="row">
                <div class="col-sm-3">
                    <label>الذكر</label><br>
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                        <div class="fileinput-new thumbnail" style="width: 218px; height: 218px;" id="tabImageHtml">
                            <img width="218" height="218" class="img-responsive" src="{{!empty($male)?asset('/images/users/'.$male):asset('/images/users/no-image.png')}}" alt=""></div>
                        <div class="fileinput-preview fileinput-exists thumbnail" style="width: 218px; height: 218px;"></div>
                        <div>
                            <span class="btn btn-default btn-file">
                                <span class="fileinput-new">اختار صورة</span>
                                <span class="fileinput-exists">تغيير الصورة</span>
                                <input type="file"
                                       name="male_image">  </span>
                            <a href="javascript:;" class="btn btn-default fileinput-exists" data-dismiss="fileinput">
                                حذف </a>
                        </div>
                        @if($errors->has('file'))
                            <strong class="red">{{ $errors->first('file') }}</strong>
                        @endif
                        <strong id="file_validate" class="red"></strong>
                    </div>
                    <div class="mb30"></div>
                </div>
                <div class="col-sm-3 col-sm-offset-2">
                    <label>الانثى</label><br>
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                        <div class="fileinput-new thumbnail" style="width: 218px; height: 218px;" id="tabImageHtml">
                            <img width="218" height="218" class="img-responsive" src="{{!empty($female)?asset('/images/users/'.$female):asset('/images/users/no-image.png')}}" alt=""></div>
                        <div class="fileinput-preview fileinput-exists thumbnail" style="width: 218px; height: 218px;"></div>
                        <div>
                          <span class="btn btn-default btn-file">
                              <span class="fileinput-new">اختار صورة</span>
                              <span class="fileinput-exists">تغيير الصورة</span>
                              <input type="file"
                                     name="female_image">  </span>
                            <a href="javascript:;" class="btn btn-default fileinput-exists" data-dismiss="fileinput">حذف</a>
                        </div>
                        @if($errors->has('file'))
                            <strong class="red">{{ $errors->first('file') }}</strong>
                        @endif
                        <strong id="file_validate" class="red"></strong>
                    </div>
                    <div class="mb30"></div>
                </div>
            </div>
            <button class="btn btn-primary">حفظ</button>
        </form>
    </div>
   </div>
</div>
@endsection
@section('script')
    <script>
    </script>
@endsection