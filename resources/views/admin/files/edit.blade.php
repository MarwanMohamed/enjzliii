<!--/**-->
<!-- * Created by PhpStorm.-->
<!-- * User: abedmq-->
<!-- * Date: 4/10/2017-->
<!-- * Time: 3:40 PM-->
<!-- */-->

@extends('admin._layout')
<?php global $setting; ?>

@section('title','الملفات')
@section('subTitle','تعديل')

@section('content')

<div class="col-md-12">
    <div class="panel panel-default">

        @if(session()->has('msg'))
        <div class="form-group">
            <span class="alert alert-info">{{session('msg')}}</span>
        </div>
        @endif
        <form action="/admin/files/edit" method="post">
            {{csrf_field()}}
            <input type="hidden" name='type'  value='{{$type}}'/> 
            <div class="panel-body">
                <div class="row">
                    <div class="form-group">
                        <label>تعديل الملفات المقبولة في {{$type_name}}</label>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="checkbox">امتداد الملفات</label>
                        <div class="col-sm-6">
                            <?php
                            
                            ?>
                            @foreach($filetypes as $filetype)
                            <div class="checkbox block"><label><input type="checkbox" name="file[]" {{(strpos($acceptFiles,$filetype->extension)!==false)?'checked':''}} value="{{$filetype->id}}"> {{$filetype->mime.'/'.$filetype->extension}} </label></div>   
                            @endforeach
                        </div>
                    </div>

                </div>


            </div>
            <div class="panel-footer">
                <button class="btn btn-primary">حفظ</button>
            </div>
        </form>
    </div>
</div>


@endsection
@section('script')
<script>

</script>
@endsection