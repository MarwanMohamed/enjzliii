@extends('admin._layout')
<?php global $setting; ?>

@section('title','الثوابت')
@section('subTitle','ميزانية المشروع')

@section('content')
@if(session()->has('msg'))
<div class="form-group">
    <div class="alert alert-info">{{session()->get('msg')}}</div>
</div>
@endif
@if(isset($q))
<form class="form-inline " action="/admin/transactions/index">

    <div class="form-group">
        <input type="text" class="form-control" value="{{($q)?$q:''}}" name="q" id="exampleInputName2"
               placeholder="بحث في الحركات المالية ">
    </div>

    <button type="submit" class="btn btn-success">عرض</button>
</form>
@endif
<br>
@if(isset($q))
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
  
  td:last-child {
    direction: initial;
}
</style>
  

<div class="form-group ">
    <button type="button" class="btn btn-info" id="addButton">اضافة جديد</button>

</div>

  
<div class="table-responsive">

<table class="table table-striped table-hover">
    <thead>
    <th>#</th>
    <th>من</th>
    <th>الى</th>
    <th>تاريخ الانشاء</th>
    <th></th>
</thead>
<tbody>
    @foreach ($projectBudgets as $key=> $projectBudget)
    <tr>
        <td>{{$projectBudget->id}}</td>

        <td>{{$projectBudget->min}} دولار</td>
        <td>{{$projectBudget->max}} دولار</td>
        <td class="date"> {{$projectBudget->created_at}}</td>
        <td>
            @if(checkPerm('deleteBudget')) <a type="submit" name="id" href="/admin/constants/deleteBudget/{{$projectBudget->id}}" class="btn btn-xs btn-danger Confirm"><i class="fa fa-times"></i></a>@endif
            @if(checkPerm('editBudget'))  <a type="submit" name="id" href="/admin/constants/editBudget/{{$projectBudget->id}}" class="btn btn-xs btn-info editBudget "><i class="fa fa-pencil"></i></a>@endif
        </td>
    </tr>
    @endforeach
</tbody>
</table>
@if(!sizeof($projectBudgets))
<div style="color:red;text-align: center;font-size: 18px;padding:15px;">لا يوجد بيانات</div>
@endif
</div>
  
{{$projectBudgets->links()}}

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

    $('#addButton').on('click', function (e) {
        // do something...
        $('#addModal').modal('show');
        $('.modal-title').text('اضافة ميزانية للمشاريع');
        $('#addForm').attr('action', '/admin/constants/addBudget');
        $('#min').val('');
        $('#max').val('');
        $('#addForm').validate();

    })

    $('.editBudget').click(function (e) {
        $(this).attr('disabled', true);
        $(this).children('i').attr('class', 'fa fa-spin fa-spinner');
        obj = $(this);
        e.preventDefault();
        $.ajax({
            url: $(this).attr('href')
        }).done(function (data) {
            $('#addModal').modal('show');
            $('.modal-title').text('تعديل ميزانية للمشاريع');
            $('#addForm').attr('action', '/admin/constants/editBudget');
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