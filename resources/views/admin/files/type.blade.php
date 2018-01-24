@extends('admin._layout')
<?php global $setting; ?>

@section('title','الملفات')
@section('subTitle','عرض الملفات')

@section('content')
@if(session()->has('msg'))
<div class="form-group">
    <div class="alert alert-info">{{session()->get('msg')}}</div>
</div>
@endif
<form class="form-inline pull-right " action="/admin/control/filesTypes">

    <div class="form-group">
        <input type="text" class="form-control" value="{{($q)?$q:''}}" name="q" id="exampleInputName2"
               placeholder="بحث في الملفات">
    </div>

    <button type="submit" class="btn btn-success">عرض</button>
</form>

<div class="form-group pull-left">
    <button type="button" class="btn btn-info " id="addButton">اضافة جديد</button>

</div>
<br>
@if(($q))
<div class="col-xs-12 text-center" style="padding:15px">نتائج البحث عن: <strong style="color:red">{{$q}}</strong></div>
@endif

<style>
    th a {
        width: 100%;
        height: 100%;
        color: #000;
        display: block;
        font-size: 16px;
    }form.form-inline.pull-right {
    float: right;
    width: 100%;
    margin-bottom: 15px;
}
</style>


<div class="table-responsive">
<table class="table table-striped table-hover">
    <thead>
    <th>#</th>
    <th>النوع</th>
    <th>الامتداد</th>
    <th>الاماكن</th>
    <th></th>
</thead>
<tbody>
    @foreach ($filetypes as $key=> $filetype)
    <tr>
        <td>{{$filetype->id}}</td>

        <td>{{$filetype->mime}} </td>
        <td>{{$filetype->extension}} </td>
        <td>
            @foreach(json_decode($filetype->type ,true) as $type)
                {{ $types[$type] }}, 
            @endforeach
        </td>
        <td>
           <a type="submit" name="id" href="/admin/files/editType/{{$filetype->id}}" class="btn btn-xs btn-info edit "><i class="fa fa-pencil"></i></a>
              <a type="submit" name="id" href="/admin/files/deleteType/{{$filetype->id}}" class="btn btn-xs btn-danger Confirm"><i class="fa fa-times"></i></a>

                {{--@if(checkPerm('edit'))  <a type="submit" name="id" href="/admin/files/editType/{{$filetype->id}}" class="btn btn-xs btn-info edit "><i class="fa fa-pencil"></i></a>@endif--}}
            {{--@if(checkPerm('delete')) <a type="submit" name="id" href="/admin/files/deleteType/{{$filetype->id}}" class="btn btn-xs btn-danger Confirm"><i class="fa fa-times"></i></a>@endif--}}
        </td>
    </tr>
    @endforeach
</tbody>
</table>
@if(!sizeof($filetypes))
<div style="color:red;text-align: center;font-size: 18px;padding:15px;">لا يوجد بيانات</div>
@endif
</div>
<!-- Modal -->
<div id="addModal" class="modal fade">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">اضافة امتداد</h4>
            </div>
            <form action="/admin/files/add" method="post" id="addForm">
                {{csrf_field()}}
                <input type="hidden" name="id" id="id" />
                <div class="modal-body">
                    <div class=""  >
                        <span class="alert-danger  " style="display: none;" id="formMsg"></span>
                    </div>
                    <div class="form-group" >
                        <label>النوع </label>
                        <input name='mime' id="mime" class='form-control' required type='text'  >
                    </div>
                    <div class="form-group" >
                        <label>الامتداد </label>
                        <input name='extension' id="extension" type='text' required class='form-control' >
                    </div>
                    <div class="form-group" >
                        <label>الاماكن </label>
                        <hr>
                        @foreach($types as $en => $ar)
                            <label class="col-md-3"><input name="type[]" type="checkbox" class="type-check" value="{{ $en }}"> {{ $ar }}</label>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type='submit' class='btn  btn-success' >حفظ  <i class="fa fa-spin fa-spinner " id="loader" style="display: none"></i></button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">اغلاق</button>
                </div>

            </form>
        </div>

    </div>
</div>



{{$filetypes->links()}}

@endsection
@section('script')
<script>

    $('#addButton').on('click', function (e) {
        // do something...
        $('#addModal').modal('show');
        $('.modal-title').text('اضافة امتداد ملف جديد');
        $('#addForm').attr('action', '/admin/files/add');
        $('#min').val('');
        $('#max').val('');
        $('#addForm').validate();

    })

    $('.edit').click(function (e) {
        $(this).attr('disabled', true);
        $(this).children('i').attr('class', 'fa fa-spin fa-spinner');
        obj = $(this);
        e.preventDefault();
        $.ajax({
            url: $(this).attr('href')
        }).done(function (data) {
            $('#addModal').modal('show');
            $('.modal-title').text('تعديل  امتداد الملف');
            $('#addForm').attr('action', '/admin/files/editType');
            $('#mime').val(data.fileType.mime);
            $('#extension').val(data.fileType.extension);
            var types = JSON.parse(data.fileType.type);
            var isExist = function (type) {
                for (var i in types){
                    if(type == types[i]) {
                        return true;
                    }
                }
                
                return false
            }
            $('.type-check').each(function(){
                this.checked = isExist(this.value);
            });
            $('#id').val(data.fileType.id);
            $('#addForm').validate();
        }).complete(function () {
            obj.attr('disabled', false);
            obj.children('i').attr('class', 'fa fa-pencil');
        })
    });

 $('#addForm').submit(function (e) {
        e.preventDefault();
        if (!$(this).valid())
            return;
        $('#loader').show();
        $(this).find('[type=submit]').attr('disabled', true);
        obj = $(this);
        $.ajax({
            url: obj.attr('action'),
            method: 'post',
            dataType: 'json',
            data: obj.serialize() + '&_token='
        }).done(function (data) {
            if(data.status==2)
                location.reload();
            else{
            myNoty(data.msg, 'success');
            obj.find(':input').val('');

    }
        }).complete(function (e, xhr) {
            $('#loader').hide();
            obj.find('[type=submit]').attr('disabled', false);
        });
    }
    );

</script>

@endsection