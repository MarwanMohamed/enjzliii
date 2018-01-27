@extends('admin._layout')
<?php global $setting; ?>

@section('title','الثوابت')
@section('subTitle','المهارات')

@section('content')

@if(session()->has('msg'))
<div class="form-group">
    <div class="alert alert-info">{{session()->get('msg')}}</div>
</div>
@endif
<form class="form-inline  pull-left" action="/admin/constants/skills">

    <div class="form-group">
        <input type="text" class="form-control" value="{{($q)?$q:''}}" name="q" id="exampleInputName2"
               placeholder="بحث في المهارات ">
    </div>

    <button type="submit" class="btn btn-success">عرض</button>
</form>
<br>


<style>
    th a {
        width: 100%;
        height: 100%;
        color: #000;
        display: block;
        font-size: 16px;
    }
  .add-new {
    float: left;
    margin-bottom: 25px;
    margin-top: -20px;
}
@media screen and (max-width: 640px) {
  form.form-inline.pull-left {
    float: right;
    width: 100%;
    margin-bottom: 30px;
}
}
</style>
@if(checkPerm('addSkill'))
<div class="add-new ">
    <button type="button" class="btn btn-info " id="addButton">اضافة جديد</button>

</div>
@endif
@if(($q))
<div class="col-xs-12 text-center" style="padding:15px;">نتائج البحث عن: <strong style="color:red">{{$q}}</strong></div>
@endif

<div class="table-responsive">
<table class="table table-striped table-hover">
    <thead>
    <th width='10%'>#</th>
    <th width='25%'>القيمة</th>
    <th width='40%'>التخصص</th>
    <th>تاريخ الانشاء</th>
    <th></th>
</thead>
<tbody>
    @foreach ($skills as $key=> $skill)
    <tr>
        <td>{{$key+1}}</td>

        <td>{{$skill->name}} </td>
        <td>{{$skill->specialization? $skill->specialization->name : 'بدون تخصص'}} </td>
        <td class="date"> {{$skill->created_at}}</td>
        <td>
            @if(checkPerm('editSkill'))  <a type="submit" name="id" href="/admin/constants/editSkill/{{$skill->id}}" class="btn btn-xs btn-info editSkill "><i class="fa fa-pencil"></i></a>@endif
            @if(checkPerm('deleteSkill')) <a type="submit" name="id" href="/admin/constants/deleteSkill/{{$skill->id}}" class="btn btn-xs btn-danger Confirm"><i class="fa fa-times"></i></a>@endif
        </td>
    </tr>
    @endforeach
</tbody>
</table>
@if(!sizeof($skills))
<div style="color:red;text-align: center;font-size: 18px;padding:15px;">لا يوجد بيانات</div>
@endif
</div>
<!-- Modal -->
<div id="addModal" class="modal fade" data-backdrop="static" >
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">اضافة مهارة</h4>
            </div>
            <form action="/admin/constants/addSkill" method="post" id="addForm">
                <input type="hidden" name="id" id="id" />
                <div class="modal-body">
                    <div class=""  >
                        <span class="alert-danger  " style="display: none;" id="formMsg"></span>
                    </div>

                    <div class="form-group" >
                        <label>الاسم </label>
                        <input name='name' id="name" type='text' required class='form-control'  >
                    </div>
                    
                  
                  <div class="form-group" >
                        <label>التخصص </label>
                        {{Form::select('specialization_id',$specializations,null,['class'=>'select2','id'=>'specialization_id','style'=>'width:100%'])}}
                    </div>
                    <div class="form-group" >
                        <label>الترتيب </label>
                        <input name='ordering' id='ordering' type='number' min="1"  required class='form-control'  >
                    </div>
                    
                  
                </div>
                <div class="modal-footer">
                    <button type='submit' class='btn btn-success' >حفظ  <i class='fa fa-spin fa-spinner ' style="display: none" id="loader"></i></button>
                    <button type="button" class="btn btn-default" data-dismiss="modal" id="closeModal">اغلاق</button>
                </div>

            </form>
        </div>

    </div>
</div>



{{$skills->links()}}

@endsection
@section('script')
<script>
    $('.select2').select2();
    $('#addButton').on('click', function (e) {
        // do something...
        $('#addModal').modal('show');
        $('.modal-title').text('اضافة مهارة');
        $('#addForm').attr('action', '/admin/constants/addSkill');
        $('#name').val('');
        $('#addForm').validate();

    })

    $('.editSkill').click(function (e) {
        $(this).attr('disabled', true);
        $(this).children('i').attr('class', 'fa fa-spin fa-spinner');
        obj = $(this);
        e.preventDefault();
        $.ajax({
            url: $(this).attr('href')
        }).done(function (data) {
            $('#addModal').modal('show');
            $('.modal-title').text('تعديل مهارة');
            $('#specialization_id').val(data.skill.specialization_id).trigger('change');;
            $('#addForm').attr('action', '/admin/constants/editSkill');
            $('#name').val(data.skill.name);
            $('#ordering').val(data.skill.ordering);
            $('#id').val(data.skill.id);
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

    $('#closeModal').click(function () {
        location.reload();
    });

</script>

@endsection