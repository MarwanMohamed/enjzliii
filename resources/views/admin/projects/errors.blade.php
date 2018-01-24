@extends('admin._layout')
<?php global $setting; ?>

@section('title','المشاريع ')
@section('subTitle','عرض المشاريع المعلقة')

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
            <th>#</th>
            <th>صاحب المشروع</th>
            <th>التاريخ</th>
            <th>العنوان</th>
            <th></th>
            <th>النوع</th>
            </thead>
            <tbody>
            @foreach ($projects as $key=> $project)
                
                @if(isset($project->fname))
                    <tr>
                        <td>{{$key+1}}</td>
                        <td><a target="_blank"
                               href="/admin/users/singleUser/{{$project->user_id}}">{{$project->fname.' '.$project->lname}}</a>
                        </td>
                        @if(isset($project->created_at))
                       
                        <td>{{getDateFromTime($project->created_at)}}</td>
                           @endif
                        <td>{{str_limit($project->title,50)}}</td>
                       
                        <td>{{($project->isCancel)?'طلب صاحب المشروع الغاء المشروع':''}}</td>
                        <td>{{$project->isView == 1 ? 'مقروء' : 'غير مقروء'}}</td>
                        <td>
                          

                            @if(checkPerm('single'))<a href="/admin/projects/single/{{$project->id}}" title="عرض"
                                                       class=" btn btn-success btn-xs"><span
                                        class="fa fa-arrows-alt"></span></a>@endif
                           
                                                        

                            <a href="javascript:;" data-id='{{$project->id}}' data-status="{{$project->status}}"
                               title="الغاء المشروع" class="cancelProject btn btn-danger btn-xs"><span
                                        class="fa fa-times"></span></a>
                            <a href="javascript:;" data-id='{{$project->id}}' data-status="{{$project->status}}"
                               title="إستئناف المشروع" class="continue btn btn-success btn-xs"><span
                                        class="fa fa-repeat"></span></a>
                                        

                        </td>
                    </tr>
                    
                @endif
                
            @endforeach
            
            </tbody>
        </table>
        @if(!sizeof($projects))
            <div style="color:red;text-align: center;font-size: 18px;padding:20px;">لا يوجد بيانات</div>
        @endif
      
    </div>
    {{$projects->links()}}
    <!-- Modal -->
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
                    <div class="modal-body">

                        <input type="hidden" name="id" id="project_id">
                        <div class="form-group">
                            <label>سبب الالغاء</label>
                            <textarea name="blockReason" class="form-control" rows="7" maxlength="500"
                                      minlength="20"></textarea></div>
                        <div class="form-group hideIf" id="">
                            <label>نسبة الأموال المسترجعة لصاحب المشروع</label>
                            <input id="ownerRate" type="number" class="form-control" name="ownerRate"
                                   placeholder="ادخل النسبة من 100"/>
                        </div>
                        <div class="form-group hideIf">
                            <label>نسبة الأموال المسترجعة لمنجز المشروع </label>
                            <input id="freelancerRate" class="form-control" disabled type="integer"
                                   name="freelancerRate" placeholder="ادخل النسبة من 100"/>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-default">حفظ</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <div id="continue_pop" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">إستئناف المشروع</h4>
                </div>
                <form action="/admin/projects/cancel" id="cancelForm" method="post">
                    {{csrf_field()}}
                    <div class="modal-body">
                        <input type="hidden" name="project_id" id="mProjectId">
                        <input type="hidden" name="mMethod" value="resume">
                        <h3>هل انت متأكد من العملية ؟</h3>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">نعم</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

@endsection
@section('script')
    <script>
        $('.cancelProject').click(function (e) {
            e.preventDefault();
            $('#cancelModel').find('#project_id').val($(this).data('id'));
//        if (parseInt($(this).data('status')) != 3) {
//            $('.hideIf').addClass('hidden');
//        }
            $('#cancelModel').modal('show');
            $('#cancelForm').validate();

        })

        $('body').on('keyup', '#ownerRate', function () {
            val = parseInt($(this).val());
            if (val < 0 || val > 100)
                myNoty('الرجاء ادخال رقم صحيح');
            else
                $('#freelancerRate').val(100 - parseInt($(this).val()));
        });


        $('body').on('click', '.continue', function () {
            var id = $(this).data('id');
            $('#mProjectId').val(id);

            $('#continue_pop').modal('show');
        });

        function cancelSubmit(e, param) {
            e.preventDefault();
            if (param.ownerRate + param.freelancerRate == 100) {
                val = parseInt($('#ownerRate').val());
                if (val < 0 || val > 100)
                    myNoty('الرجاء ادخال رقم صحيح');
                else
                    $(this).submit();
            } else {
                myNoty('يجب ان مجموع نسبة صاحب المشروع ومنجز المشروع تساوي100')
            }
        }
    </script>
@endsection