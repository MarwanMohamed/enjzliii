@extends('admin._layout')
<?php global $setting; ?>

@section('title','الملفات')
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
    <th width='30%'>الاسم</th>
    <th width='50%'>الملفات</th>
    <th></th>
</thead>
<tbody>
    <tr>
        <td>1</td>
        <td>اضافة مشروع</td>
        <td>{{str_replace('|',' , ',$setting['addProjectFiles'])}}</td>
        <td>
            @if(checkPerm('edit'))  <a  name="id" href="/admin/files/edit/1" class="btn btn-info btn-xs "><i class="fa fa-pencil"></i></a>@endif
        </td>
    </tr>
<td>2</td>
<td>الملفات المرفقة في اضافة عمل</td>
<td>{{str_replace('|',' , ',$setting['attachAddPort'])}}</td>
<td>
    @if(checkPerm('edit'))  <a  name="id" href="/admin/files/edit/2" class="btn btn-info btn-xs "><i class="fa fa-pencil"></i></a>@endif
</td>
</tr>
<tr>

    <td>3</td>
    <td>الصورة المصغرة في اضافة عمل</td>
    <td>{{str_replace('|',' , ',$setting['avatarAddPort'])}}</td>
    <td>
        @if(checkPerm('edit'))  <a  name="id" href="/admin/files/edit/3" class="btn btn-info btn-xs "><i class="fa fa-pencil"></i></a>@endif
    </td>
</tr>
<tr>

    <td>4</td>
    <td>اضافة عرض</td>
    <td>{{str_replace('|',' , ',$setting['addBid'])}}</td>
    <td>
        @if(checkPerm('edit'))  <a  name="id" href="/admin/files/edit/4" class="btn btn-info btn-xs "><i class="fa fa-pencil"></i></a>@endif
    </td>
</tr>
<tr>

    <td>5</td>
    <td>اضافة نقاش</td>
    <td>{{str_replace('|',' , ',$setting['addDesc'])}}</td>
    <td>
        @if(checkPerm('edit'))  <a  name="id" href="/admin/files/edit/5" class="btn btn-info btn-xs "><i class="fa fa-pencil"></i></a>@endif
    </td>
</tr>
<tr>

    <td>6</td>
    <td>ارسال رسالة</td>
    <td>{{str_replace('|',' , ',$setting['sendMesg'])}}</td>
    <td>
        @if(checkPerm('edit'))  <a  name="id" href="/admin/files/edit/6" class="btn btn-info btn-xs "><i class="fa fa-pencil"></i></a>@endif
    </td>
    </tbody>
</table>
</div>

<!-- Modal -->
<div id="addModal" class="modal fade">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">اضافة ميزانية للمشاريع</h4>
            </div>
            <form action="/admin/constants/addBudget" method="post" id="addForm">
                {{csrf_field()}}
                <input type="hidden" name="id" id="id" />
                <div class="modal-body">
                    <div class=""  >
                        <span class="alert-danger  " style="display: none;" id="formMsg"></span>
                    </div>
                    <div class="form-group" >
                        <label>الحد الأدنى </label>
                        <input name='min' id="min" class='form-control' required type='number' min='0'  >
                    </div>
                    <div class="form-group" >
                        <label>الحد الأعلى </label>
                        <input name='max' id="max" type='number' required class='form-control' min='0'  >
                    </div>
                </div>
                <div class="modal-footer">
                    <button type='submit' class='btn btn-success' >حفظ </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">اغلاق</button>
                </div>

            </form>
        </div>

    </div>
</div>





@endsection
@section('script')
<script>


    $('.edit').click(function (e) {
        $(this).attr('disabled', true);
        $(this).children('i').attr('class', 'fa fa-spin fa-spinner');
        obj = $(this);
        e.preventDefault();
        $.ajax({
            url: $(this).attr('href')
        }).done(function (data) {
            $('#addModal').modal('show');
            $('.modal-title').text('تعديل  الملفات');
            $('#addForm').attr('action', '/admin/files/edit');
            $('#min').val(data.budget.min);
            $('#max').val(data.budget.max);
            $('#id').val(data.budget.id);
            $('#addForm').validate();
        }).complete(function () {
            obj.attr('disabled', false);
            obj.children('i').attr('class', 'fa fa-pencil');
        })
    });


    $('#addForm').submit(function (e) {
        if (parseInt($('#min').val()) > parseInt($('#max').val())) {
            $('#formMsg').text('يجب ان يكون الحد الأدنى اصغر من الحد الأعلى');
            $('#formMsg').show();
            return false;
        }
    });
</script>

@endsection