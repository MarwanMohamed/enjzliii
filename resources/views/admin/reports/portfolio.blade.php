@extends('admin._layout')
<?php global $setting; ?>

@section('title','التبليغات')
@section('subTitle','المشاريع')

@section('content')
@if(session()->has('msg'))
<div class="form-group">
    <div class="alert alert-info">{{session()->get('msg')}}</div>
</div>
@endif
<form class="form-inline " action="/admin/reports/portifolio">

    <div class="form-group">
        <input type="text" class="form-control" value="{{($q)?$q:''}}" name="q" id="exampleInputName2"
               placeholder="بحث في التبليغات ">
    </div>

    <div class="form-group">
        {!! Form::select('status',['الكل','قيد التنفيذ','تم الحل'],$status,['class'=>'form-control'])!!}
       
    </div>
    <button type="submit" class="btn btn-success">عرض</button>
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
    <th>العمل</th>
    <th>صاحب المشروع</th>
    <th>عدد التبليغات</th>
    <th>النوع</th>
    <th></th>
</thead>
<tbody>
    @foreach ($portfolios as $key=> $portfolio)
    <tr>
        <td>{{$portfolio->id}}</td>

        <td><a href='/admin/portfolios/single/{{$portfolio->id}}'>{{str_limit($portfolio->title,30)}}</a></td>
        <td>{{$portfolio->owner->fullname()}}</td>
        <td>{{$portfolio->reports->count()}}</td>
        <td>{{$portfolio->reports[$key]->isView == 0  ? 'غير مقروء' : 'مقروء'}}</td>
                        <td> 
                            @if(checkPerm('show'))<a href="/admin/reports/show/1/{{$portfolio->id}}" title="عرض" class=" btn btn-success btn-xs"><span
                                    class="fa fa-arrows-alt"></span></a>@endif
                          
                        </td>
                        </tr>
                        @endforeach
                        </tbody>
                        </table>
                        @if(!sizeof($portfolios))
                        <div style="color:red;text-align: center;font-size: 18px;padding:20px;">لا يوجد بيانات</div>
                        @endif
</div>
                        {{$portfolios->links()}}

                        <!-- Modal -->
                        <div id="blockModel" class="modal fade" role="dialog">
                            <div class="modal-dialog">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">سبب الحظر</h4>
                                    </div>
                                    <form action="/admin/bids/block" id="blockForm" method="post">
                                        {{csrf_field()}}
                                        <div class="modal-body">
                                            <p>ادخل سبب الحظر</p>
                                            <input type="hidden" name="id" id="bid_id">
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
                                    <form action="/admin/bids/cancel" onsubmit="cancelSubmit()" id="cancelForm" method="post">
                                        {{csrf_field()}}
                                        <div class="modal-body">  

                                            <input type="hidden" name="id" id="bid_id">
                                            <div class="form-group">
                                                <label>سبب الالغاء</label>
                                                <textarea name="blockReason" class="form-control" rows="7" maxlength="500" minlength="20"></textarea></div>
                                            <div class="form-group hideIf" id="">
                                                <label>نسبة الأموال المسترجعة لصاحب المشروع</label>
                                                <input id="ownerRate" type="number" class="form-control" name="ownerRate" placeholder="ادخل النسبة من 100"/>
                                            </div>
                                            <div class="form-group hideIf">
                                                <label>نسبة الأموال المسترجعةلمنفذ المشروع </label>
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
                                    $('#blockModel').find('#bid_id').val($(this).data('id'));
                                    $('#blockModel').modal('show');
                                    $('#blockForm').validate();

                                })
                                $('.cancelProject').click(function (e) {
                                    e.preventDefault();
                                    $('#cancelModel').find('#bid_id').val($(this).data('id'));
                                    if (parseInt($(this).data('status')) != 3) {
                                        $('.hideIf').addClass('hidden');
                                    }
                                    $('#cancelModel').modal('show');
                                    $('#cancelForm').validate();

                                })
                            });

                            $('body').on('keyup', '#ownerRate', function () {
                                val = parseInt($(this).val());
                                if (val < 0 || val > 100)
                                    myNoty('الرجاء ادخل رقم صحيح');
                                else
                                    $('#freelancerRate').val(100 - parseInt($(this).val()));
                            });


                            function cancelSubmit(e, param) {
                                e.preventDefault();
                                if (param.ownerRate + param.freelancerRate == 100) {
                                    val = parseInt($('#ownerRate').val());
                                    if (val < 0 || val > 100)
                                        myNoty('الرجاء ادخل رقم صحيح');
                                    else
                                        $(this).submit();
                                } else {
                                    myNoty('يجب ان مجموع نسبة صاحب المشروع ومنفذ المشروع تساوي100')
                                }
                            }
                        </script>
                        @endsection