@extends('admin._layout')
<?php global $setting;?>

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
        <div class="form-group">
            <input type="text" class="form-control" value="{{($owner)?$owner:''}}" name="owner" id="exampleInputName2"
                   placeholder="بحث بحسب صاحب المشروع">
        </div>

        <div class="form-group">
            <select name="status" id="" class="form-control ">
                <option value="0" {{$status==0?'selected':''}}>الكل</option>
                <option value="2" {{$status==2?'selected':''}}>مفتوح</option>
                <option value="3" {{$status==3?'selected':''}} >قيد التنفيذ</option>
                <option value="4" {{$status==4?'selected':''}} >ملغي</option>
                <option value="5" {{$status==5?'selected':''}} >مغلق</option>
                <option value="6" {{$status==6?'selected':''}} >منتهي</option>
                <option value="7" {{$status==7?'selected':''}} >محظور</option>
            </select>
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
      
        <th><a href="#">نوع المشروع</a></th>
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
                <td>{{$project->isPrivate == 1 ? 'خاص'  : 'عادى'}}</td>
                <td>
                    <a href="/admin/projects/single/{{$project->id}}" title="عرض" class=" btn btn-success btn-xs"><span
                                class="fa fa-arrows-alt"></span></a>

                               
                    @if($project->isBlock||$project->status<4)<a href="/admin/projects/{{(!$project->isBlock)?'block':'unblock/'.$project->id}} " title="{{(!$project->isBlock)?'حظر':'الغاء الحظر'}}" data-id="{{$project->id}}" class="btn btn-warning btn-xs {{(!$project->isBlock)?'block':'Confirm'}}"><span
                                class="fa fa-eye{{($project->status<4)?'-slash':''}}"></span></a>@endif
          
           {{--@if($project->status<4)<a href="javascript:;" data-id='{{$project->id}}' data-status={{$project->status}} title="الغاء المشروع" class="cancelProject btn btn-danger btn-xs"><span--}}
                                {{--class="fa fa-times"></span></a>@endif--}}
                    </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
    @if(!sizeof($projects))
        <div style="color:red;text-align: center;font-size: 18px">لا يوجد بيانات</div>
    @endif

    {{$projects->links()}}

    <!-- Modal -->
    <div id="blockModel" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">سبب الحظر</h4>
                </div>
                <form action="/admin/projects/block" id="blockForm" method="post">
                    {{csrf_field()}}
                    <div class="modal-body">
                        <p>ادخل سبب الحظر</p>
                        <input type="hidden" name="id" id="project_id">
                        <div class="form-group"><textarea name="blockReason" class="form-control" rows="7" required maxlength="500" minlength="20"></textarea></div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-default" >حظر</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <!-- Modal -->
    <div id="cancelModel" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">سبب الحظر</h4>
                </div>
                <form action="/admin/projects/cancel" onsubmit="cancelSubmit()" id="cancelForm" method="post">
                    {{csrf_field()}}
                    <div class="modal-body">

                        <input type="hidden" name="id" id="project_id">
                        <div class="form-group">
                            <label>سبب الالغاء</label>
                            <textarea name="blockReason" class="form-control" rows="7" maxlength="500" minlength="20"></textarea></div>
                        <div class="form-group hideIf" id="">
                            <label>نسبة الأموال المسترجعة لصاحب المشروع</label>
                            <input id="ownerRate" type="number" class="form-control" name="ownerRate" placeholder="ادخل النسبة من 100"/>
                        </div>
                        <div class="form-group hideIf">
                            <label>نسبة الأموال المسترجعة لمنفذ المشروع </label>
                            <input id="freelancerRate" class="form-control" disabled type="integer" name="freelancerRate" placeholder="ادخل النسبة من 100"/>
                        </div>
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
            $('.block').click(function (e) {
                e.preventDefault();
                $('#blockModel').find('#project_id').val($(this).data('id'));
                $('#blockModel').modal('show');
                $('#blockForm').validate();

            })
            $('.cancelProject').click(function (e) {
                e.preventDefault();
                $('#cancelModel').find('#project_id').val($(this).data('id'));
                if(parseInt($(this).data('status'))!=3){
                    $('.hideIf').addClass('hidden');
                }
                $('#cancelModel').modal('show');
                $('#cancelForm').validate();

            })
        });
        
        $('body').on('keyup','#ownerRate',function(){
            val=parseInt($(this).val());
            if(val<0||val>100)
                myNoty('الرجاء ادخل رقم صحيح');
            else    
                $('#freelancerRate').val(100-parseInt($(this).val()));
        });
        
        
        function cancelSubmit (e,param){
            e.preventDefault();
            if(param.ownerRate+param.freelancerRate==100){
                 val=parseInt($('#ownerRate').val());
            if(val<0||val>100)
                    myNoty('الرجاء ادخل رقم صحيح');
            else
                $(this).submit();
        }else{
                myNoty('يجب ان مجموع نسبة صاحب المشروع ومنفذ المشروع تساوي100')
            }
        }
    </script>
@endsection