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
    <form class="form-inline " action="/admin/users">

        <div class="form-group">
            <input type="text" class="form-control" value="{{($q)?$q:''}}" name="q" id="exampleInputName2"
                   placeholder="بحث..">
        </div>
        <div class="form-group">
            <select name="status" id="" class="form-control ">
                <option value="0" {{$status==0?'selected':''}}>الكل</option>
                <option value="1" {{$status==1?'selected':''}}>مفعل</option>
                <option value="2" {{$status==2?'selected':''}}>محظور</option>
            </select>
        </div>
        <div class="form-group">
            <select name="userType" id="" class="form-control ">
                <option value="3" {{$userType==3?'selected':''}}>الكل</option>
                <option value="1" {{$userType==1?'selected':''}}>منجز مشاريع </option>
                <option value="2" {{$userType==2?'selected':''}} >صاحب مشروع</option>
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
               href="/admin/users?{{$searchParam}}orderBy=id&{{($orderBy=='id'&&$orderByType=='asc')?'desc=1':'asc=1'}}">#</a></th>
        <th><a title="ترتيب حسب اسم "
               href="/admin/users?{{$searchParam}}orderBy=username&{{($orderBy=='username'&&$orderByType=='asc')?'desc=1':'asc=1'}}">اسم
                </a></th>
        <th><a title="ترتيب حسب تاريخ التسجيل"
               href="/admin/users?{{$searchParam}}orderBy=created_at&{{($orderBy=='created_at'&&$orderByType=='asc')?'desc=1':'asc=1'}}">تاريخ
                التسجيل</a></th>
        <th><a title="ترتيب حسب آخر دخول"
               href="/admin/users?{{$searchParam}}orderBy=lastLogin&{{($orderBy=='lastLogin'&&$orderByType=='asc')?'desc=1':'asc=1'}}">آخر
                دخول</a></th>
        <th><a title="ترتيب حسب حالة الحساب"
               href="/admin/users?{{$searchParam}}orderBy=status&{{($orderBy=='status'&&$orderByType=='asc')?'desc=1':'asc=1'}}">حالة
                الحساب</a></th>
        <th>مفعل</th>
        <th><a title="ترتيب حسب نوع الحساب"
               href="/admin/users?{{$searchParam}}orderBy=type&{{($orderBy=='type'&&$orderByType=='asc')?'desc=1':'asc=1'}}">نوع الحساب</a>
        </th>
        <th></th>
        </thead>
        <tbody>
        @foreach ($users as $key=> $user)

            <tr>
                <td>{{$user->id}}</td>
                <td><a target="_blank"
                       href="/admin/users/singleUser/{{$user->id}}">{{$user->fullname()}}</a>
                </td>
                <td>{{getDateFromTime($user->created_at)}}</td>
                <td>{{(($user->lastLogin))}}</td>
                <td>{{(getUserState($user))}}</td>
                <td>{{$user->emailConfirm == 1?'نعم':'لا'}}</td>
                <td>{{(getUserType($user->type))}}</td>

                <td>
                   <a href="/admin/users/VIP/{{$user->id}}" title="ترقية الى سوبر" class="upgrade btn btn-success btn-xs"><span
                                class="fa fa-star" ></span></a>
                    <a href="/admin/users/single/{{$user->id}}" title="عرض" class=" btn btn-success btn-xs"><span
                                class="fa fa-arrows-alt"></span></a>
                    <a href="/admin/users/{!!$user->status!=2?'block':'activate'!!}/{{$user->id}}"
                       title="{!!$user->status!=2?'حظر':'تفعيل'!!}" data-id="{{$user->id}}"
                       class="{!!$user->status!=2?'block':'activate Confirm'!!}  btn btn-info btn-xs"><span
                                class="fa fa-eye{!!$user->status!=2?'-slash':''!!}"></span></a>
                    <a href="javascript:;" title="مراسلة" data-id="{{$user->id}}" class="notifcation btn btn-warning btn-xs"><span
                                class="fa fa-envelope"></span></a>

                    <a href="/admin/users/activateAccount/{{$user->id}}"
                        data-id="{{$user->id}}"
                       class="Confirm btn btn-info btn-xs"><span
                                class="fa fa-edit"></span></a>
                   <a href="/admin/users/delete/{{$user->id}}" title="حذف" class="Confirm btn btn-danger btn-xs"><span
                                class="fa fa-times"></span></a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
    @if(!sizeof($users))
        <div style="color:red;text-align: center;font-size: 18px">لا يوجد بيانات</div>
    @endif

    {{$users->appends(['q'=>$q])->links()}}

    <!-- Modal -->
    <div id="blockModel" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">سبب الحظر</h4>
                </div>
                <form action="/admin/users/block" id="blockForm" method="post">
                    {{csrf_field()}}
                    <div class="modal-body">
                        <p>ادخل سبب الحظر</p>
                        <input type="hidden" name="id" id="user_id">
                        <div class="form-group"><textarea name="blockReason" class="form-control" rows="7" required maxlength="500" minlength="20"></textarea></div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-default" >حفظ</button>
                    </div>
                </form>
            </div>

        </div>
    </div>


    <!-- Modal -->
    <div id="notifcationModel" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">رسالة ادارية</h4>
                </div>
                <form action="/admin/users/notifcation" id="notifcationForm" method="post">
                    {{csrf_field()}}
                    <div class="modal-body">
                        <p>ادخل نص الرسالة</p>
                        <input type="hidden" name="id" id="user_id">
                        <div class="form-group"><textarea name="text" maxlength="500" rows="7" class="form-control" required minlength="20"></textarea></div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-default" >ارسال</button>
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
                $('#blockModel').find('#user_id').val($(this).data('id'));
                $('#blockModel').modal('show');
                $('#blockForm').validate();

            });

            $('.notifcation').click(function (e) {
                e.preventDefault();
                $('#notifcationModel').find('#user_id').val($(this).data('id'));
                $('#notifcationModel').modal('show');
                $('#notifcationForm').validate();

            })

        });
    </script>
@endsection