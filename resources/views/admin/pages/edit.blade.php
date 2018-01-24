@extends('admin._layout')
<?php global $setting; ?>
@section('title','الصفحات')
@section('subTitle','تعديل')
@section('content')
<link rel="stylesheet" href="/panel/css/bootstrap-wysihtml5.css" />
    <form action="/admin/pages/edit" method="post">
<div class="col-md-9">
    <div class="panel panel-default">
      <div class="panel-body">
        @if(session()->has('msg'))
        <div class="form-group">
            <span class="alert alert-info">{{session('msg')}}</span>
        </div>
        @endif
    
            {{csrf_field()}}
            <input type="hidden" name="id" value="{{$page->id}}"/>
            <div class="panel-body">
                <div class="row">
                    <div class="form-group">
                        <label>عنوان الصفحة</label>
                        <input type="text" name="title" class="form-control" value="{{$page->title}}"/>
                    </div>
                    <div class="form-group">
                        <label>تفاصيل الصفحة</label>
                        <textarea id="inlineedit2" name='text' placeholder="ادخل تفاصيل الصفحة" class="form-control" rows="10">{{$page->text}}</textarea>
                    </div>
                </div>
            </div>
    </div>
  </div>
</div>
        <div class="col-sm-3">
           <div class="panel panel-default">
            <div class="panel-body">
              <button class="btn btn-primary">حفظ</button>
            </div>
          </div>
        </div>
      </form>
@endsection
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.6.2/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.6.2/config.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.6.2/contents.css"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.6.2/lang/ar.js"></script>
<script>
   CKEDITOR.replace( 'text' );
</script>
@endsection