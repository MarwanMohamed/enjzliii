@extends('admin._layout')
<?php global $setting; ?>

@section('title','الثوابت')
@section('subTitle','الاسئلة الشائعة')

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
@media screen and (max-width: 640px) {
  form.form-inline.pull-left {
    float: right;
    width: 100%;
    margin-bottom: 30px;
}
}
</style>

<div class="form-group ">
    <button type="button" class="btn btn-info " id="addButton">اضافة جديد</button>

</div>

<div class="table-responsive">
<table class="table table-striped table-hover">
    <thead>
    <th>#</th>
    <th>السؤال</th>
    <th>الجواب</th>
    <th>النوع</th>
    <th>تاريخ الانشاء</th>
    <th></th>
</thead>
<tbody>
    @foreach ($FAQs as $key=> $FAQ)
    <tr>
        <td>{{$FAQ->id}}</td>

        <td>{{str_limit($FAQ->question,20)}}</td>
        <td>{{str_limit($FAQ->answer,20)}}</td>
        <td>{{($FAQ->isVIP)?'يظهر في super':'لا يظهر في super'}}</td>
        <td class="date"> {{$FAQ->created_at}}</td>
        <td>
            @if(checkPerm('editfaq'))  <a type="submit" name="id" href="/admin/constants/editfaq/{{$FAQ->id}}" class="btn btn-xs btn-info editBudget "><i class="fa fa-pencil"></i></a>@endif
            @if(checkPerm('deletefaq')) <a type="submit" name="id" href="/admin/constants/deletefaq/{{$FAQ->id}}" class="btn btn-xs btn-danger Confirm"><i class="fa fa-times"></i></a>@endif
        </td>
    </tr>
    @endforeach
</tbody>
</table>
@if(!sizeof($FAQs))
<div style="color:red;text-align: center;font-size: 18px;padding:15px;">لا يوجد بيانات 1</div>
@endif
</div>
<!-- Modal -->
<div id="addModal" class="modal fade">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">اضافة سؤال شائع</h4>
            </div>
            <form action="/admin/constants/addfaq" method="post" id="addForm">
                {{csrf_field()}}
                <input type="hidden" name="id" id="id1" />
                <div class="modal-body">
                    <div class=""  >
                        <span class="alert-danger  " style="display: none;" id="formMsg"></span>
                    </div>
                    <div class="form-group" >
                        <label>السؤال </label>
                        <textarea rows="5" name='question' id="question" class='form-control' required type='text' required minlength="5" maxlength="5000"  ></textarea>
                    </div>
                    <div class="form-group" >
                        <label>الجواب </label>
                        <textarea rows="5" name='answer' id="answer" type='text' required class='form-control' required minlength="5" maxlength="5000"  ></textarea>
                    </div>
                    
                    <div class="form-group" >

                        <div class="checkbox block"><label><input name="isVIP" id="isVIP" type="checkbox"> ظهور السؤال في صفحة super</label></div>
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



{{$FAQs->links()}}

@endsection
@section('script')
<script>

    $('#addButton').on('click', function (e) {
        // do something...
        $('#addModal').modal('show');
        $('.modal-title').text('اضافة سؤال شائع');
        $('#addForm').attr('action', '/admin/constants/addfaq');
        $('#question').val('');
        $('#answer').val('');
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
            obj.attr('disabled', false);
            obj.children('i').attr('class', 'fa fa-pencil');
            $('#addModal').modal('show');
            $('.modal-title').text('تعديل سؤال شائع');
            $('#addForm').attr('action', '/admin/constants/editfaq');
            $('#question').val(data.FAQ.question);
            $('#answer').val(data.FAQ.answer);
            $('#isVIP').attr('checked',data.FAQ.isVIP);
            $('#id1').val(data.FAQ.id);
            $('#addForm').validate();
        }).complete(function () {
            obj.attr('disabled', false);
            obj.children('i').attr('class', 'fa fa-pencil');
        })
    });

</script>



@endsection