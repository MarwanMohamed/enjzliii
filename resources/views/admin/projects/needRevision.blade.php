@extends('admin._layout')
<?php global $setting; ?>

@section('title','حسابات المستخدمين')
@section('subTitle','عرض')

@section('content')
@if(session()->has('msg'))
<div class="form-group">
    <div class="alert alert-info">{{session()->get('msg')}}</div>
</div>
@endif
<form class="form-inline " action="/admin/projects">

    <div class="form-group">
        <input type="text" class="form-control" value="{{($q)?$q:''}}" name="q" id="exampleInputName2"
               placeholder="بحث في المشروع">
    </div>

    <button type="submit" class="btn btn-success">بحث</button>
</form>
<br>
@if(($q))
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
</style>
<div class="table-responsive">
<table class="table table-striped table-hover">
    <thead>
    <th><a title="ترتيب حسب رقم المعرف"
           href="/admin/projects?{{$searchParam}}orderBy=id&{{($orderBy=='id'&&$orderByType=='asc')?'desc=1':'asc=1'}}">#</a></th>
    <th><a title="ترتيب حسب اسم صاحب الحساب"
           href="/admin/projects?{{$searchParam}}orderBy=username&{{($orderBy=='username'&&$orderByType=='asc')?'desc=1':'asc=1'}}">صاحب المشروع</a></th>
    <th><a title="ترتيب حسب تاريخ الإنشاء"
           href="/admin/projects?{{$searchParam}}orderBy=created_at&{{($orderBy=='created_at'&&$orderByType=='asc')?'desc=1':'asc=1'}}">تاريخ
            الإنشاء</a></th>
    <th><a title="ترتيب حسب العنوان"
           href="/admin/projects?{{$searchParam}}orderBy=title&{{($orderBy=='title'&&$orderByType=='asc')?'desc=1':'asc=1'}}">العنوان</a></th>
    <th><a title="ترتيب حسب حالة مشروع"
           href="/admin/projects?{{$searchParam}}orderBy=status&{{($orderBy=='status'&&$orderByType=='asc')?'desc=1':'asc=1'}}">حالة
            المشروع</a></th>
            <th><a title="ترتيب حسب حالة مشروع"
           href="/admin/projects?{{$searchParam}}orderBy=status&{{($orderBy=='status'&&$orderByType=='asc')?'desc=1':'asc=1'}}">نوع
            المشروع</a></th>
    <th></th>
</thead>
<tbody>
    @foreach ($projects as $key=> $project)

    <tr>
        <td>{{$project->id}}</td>
        <td><a target="_blank"
               href="/admin/users/singleUser/{{$project->owner->id}}">{{$project->owner->fullname()}}</a>
        </td>
        <td>{{getDateFromTime($project->created_at)}}</td>
        <td>{{str_limit($project->title,50)}}</td>
        <td>{{projectStatus($project,$setting)}}</td>
        <td>{{$project->isView == 1 ? 'مقروء' : 'غير مقروء'}}</td>
        <td>
          
                @if(checkPerm('single'))<a href="/admin/projects/single/{{$project->id}}" title="عرض" class=" btn btn-success btn-xs"><span
                    class="fa fa-arrows-alt"></span></a>@endif
             @if(checkPerm('approve'))<a href="/admin/projects/approve/{{$project->id}}" title="الموافقة على المشروع" class="btn btn-warning btn-xs Confirm"><span
                    class="fa fa-plus"></span></a>@endif
      

             @if(checkPerm('cancel'))<a href="javascript:;" data-id='{{$project->id}}' data-status={{$project->status}} title="الغاء المشروع" class="cancelProject btn btn-danger btn-xs"><span
                    class="fa fa-times"></span></a>@endif
           
        </td>
    </tr>
    @endforeach
</tbody>
</table>
@if(!sizeof($projects))
<div style="color:red;text-align: center;font-size: 18px;padding:20px;">لا يوجد بيانات</div>
@endif
  
</div>

{{$projects->links()}}

<div id="cancelModel" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">سبب الإلغاء</h4>
            </div>
            <form action="/admin/projects/cancel" onsubmit="cancelSubmit()" id="cancelForm" method="post">
                {{csrf_field()}}
                <input type="hidden" value="1" name='cancel'/>
                <div class="modal-body">

                    <input type="hidden" name="id" id="project_id">
                    <div class="form-group">
                        <label>سبب الإلغاء</label>
                        <textarea name="blockReason" class="form-control" rows="7" maxlength="500" minlength="20"></textarea></div>
                  
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">الغاء</button>
                    <button type="submit" class="btn btn-default" >حفظ</button>
                </div>
            </form>
        </div>

    </div>
</div>

@endsection
@section('script')
<script>
    $(function () {
        $('.cancelProject').click(function (e) {
            e.preventDefault();
            $('#cancelModel').find('#project_id').val($(this).data('id'));
            $('#cancelModel').modal('show');
            $('#cancelForm').validate();

        })
    });
</script>
@endsection