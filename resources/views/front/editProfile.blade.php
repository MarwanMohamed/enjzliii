@extends('front.__template')
@section('title','تعديل بياناتي')
@section('content')
    <?php global $setting; ?>
    <style>
        .editError label.error {
            position: absolute;
            left: 11px;
            width: initial;
            padding: 10px;
            font-size: 13px;
            color: red;
            TOP: 16px;
        }

        .item_profile h2, .item_sc2 h2 {
            margin-top: 15px;
            margin-bottom: 5px;
        }

        label.error {
            font-size: 13px;
            display: none !important;
        }

        input.error {
            border-color: red !important;
        }

        ul.dropdown-menu {
            overflow: scroll;
            max-height: 340px;
            overflow-x: hidden;
        }

        ul.dropdown-menu::-webkit-scrollbar {
            width: 5px;
        }

        ul.dropdown-menu::-webkit-scrollbar-track {
            border-radius: 5px;
        }

        ul.dropdown-menu::-webkit-scrollbar-thumb {
            border-radius: 5px;
            background: #fe5339;
        }

        label.error {
            display: none;
        }
    </style>
    @include('front.heade_info')
    <section class="s_protfolio">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <form action="/handleEditProfile" id="editProfile" method="post">
                        <div id="msg"></div>
                        {{csrf_field()}}
                        <div class="all_item_profsingle">
                            <div class="heade_div2">
                                <h2>تعديل الملف الشخصي</h2>
                            </div>
                            <div class="item_profile">
                                <h2>نوع الحساب<span class=" ft-15" aria-required="true"> * </span></h2>
                                @if (!$user->isVIP)
                                    <div class="info_perfs">
                                        <h2>إختيار نوع الحساب حسب نشاطك</h2>
                                        <div class="slideTows">
                                            <input type="checkbox" value="1" id="slideTows"
                                                   {{(($user->type==1||$user->type==3)&& $user->isFinishProfile==1)?'checked':''}} name="type1"/>
                                            <label for="slideTows">منجز مشاريع</label>
                                        </div>
                                        <div class="slideTows">
                                            <input type="checkbox" value="2" id="slideTows2"
                                                   {{(($user->type==2||$user->type==3) && $user->isFinishProfile==1)?'checked':''}} name="type2"/>
                                            <label for="slideTows2">صاحب مشاريع</label>
                                        </div>
                                    </div>
                                @else
                                    <div class="info_perfs">
                                        <h2 style="margin: 0;">إختيار نوع الحساب حسب نشاطك</h2>
                                        <div class="slideTows">
                                            <input type="checkbox" value="1" id="slideTows" checked="" name="type2"/>
                                            <label for="">منجز مشاريع</label>
                                        </div>
                                    </div>
                                @endif
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-6 editError">
                                                <h2> الأسم الأول<span class=" ft-15" aria-required="true"> * </span>
                                                </h2>
                                                <input class="{{$errors->has('fname')?'input-has-error':''}}"
                                                       type="text" required placeholder="ادخل الاسم الأول" minlength="3"
                                                       name="fname" value="{{$user->fname}}">
                                            </div>
                                            <div class="col-md-6 editError">
                                                <h2> الأسم الاخير<span class=" ft-15" aria-required="true"> * </span>
                                                </h2>
                                                <input class="{{$errors->has('lname')?'input-has-error':''}}"
                                                       type="text" required placeholder="ادخل الاسم الأخير"
                                                       minlength="3" name="lname" value="{{$user->lname}}">
                                            </div>
                                            <div class="col-md-12 editError">
                                                <h2> البريد الإلكتروني<span class=" ft-15"
                                                                            aria-required="true"> * </span></h2>
                                                <input class="{{$errors->has('email')?'input-has-error':''}}"
                                                       type="email" placeholder="ادخل البريد الإلكتروني"
                                                       name="new_email" required value="{{$user->email}}">
                                            </div>
                                            <div class="col-md-12 editError">
                                                <h2> اسم المستخدم<span class=" ft-15" aria-required="true"> * </span>
                                                </h2>
                                                <input class="{{$errors->has('username')?'input-has-error':''}}"
                                                       @if($user->username) disabled @endif type="text"
                                                       placeholder="ادخل اسم المستخدم" class="checkUserName"
                                                       name="username" required value="{{$user->username}}">
                                                <i class="fa fa-check hidden username-check"
                                                   style="color: #42bf00;position: absolute;left: 31px;font-size: 24px;top: 29px;"></i>
                                                <i class="fa fa-close hidden username-close"
                                                   style="color: red;position: absolute;left: 31px;font-size: 24px;top: 29px;"></i>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="city">
                                                    <h2>المدينة و الدولة <span class=" ft-15"
                                                                               aria-required="true"> * </span></h2>
                                                    <div class="selects3s select-country">
                                                        <div class="dropdown">
                                                            <button class="btn dropdown-toggle" type="button"
                                                                    data-toggle="dropdown">اختر دولة
                                                                <span class="caret"></span></button>
                                                            <ul class="dropdown-menu">
                                                                <li><a href="javascript:;" data-value="">اختر الدولة</a>
                                                                </li>

                                                                @foreach($countries as $country)
                                                                    <li {{($country->id==$user->country_id)?'selected':''}} >
                                                                        <a href="javascript:;"
                                                                           data-value="{{$country->id}}">{{$country->name}}</a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                            <input type="hidden"
                                                                   value="{{sizeof($countries)?$countries[0]->id:''}}"
                                                                   class="drop_sel" name="country_id"/>
                                                        </div>
                                                    </div>
                                                    <div class="selects50">
                                                        <input type="text" name="city" placeholder="ادخل المدينة"
                                                               value="{{$user->city}}" placeholder="المدينة">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="phpasd">
                                                    <h2> رقم الهاتف <span class=" ft-15"
                                                                          aria-required="true"> * </span>{{-- <span id="phoneAcSp">@if($user->mobileConfirm)<span class="phone_active hidden">مفعل</span>@else<span class="not_active hidden">غير مفعل</span>@endif</span> --}}
                                                    </h2>
                                                    <div class="phoness">
                                                        <input class="{{$errors->has('mobile')?'input-has-error':''}}"
                                                               type="text" placeholder="ادخل رقم الهاتف" required
                                                               name="mobile" id="mobile" value="{{$user->mobile}}">
                                                    </div>
                                                    {{--{{dd($user)}}--}}
                                                    <div class="selectss select-country-code haveshp">
                                                        <div class="dropdown">
                                                            <button class="btn dropdown-toggle" type="button"
                                                                data-toggle="dropdown">

                                                                @if($user && isset($country))
                                                                    {{$country->code.' +'.$country->zipCode}}
                                                                    @else
                                                                {{sizeof($countries)?($countries[0]->code.' +'.$countries[0]->zipCode):''}}
                                                                @endif
                                                                {{--<span class="caret"></span>--}}


                                                            </button>
                                                            <ul style="display: none" class="dropdown-menu">
                                                                @foreach($countries as $country)
                                                                    <li {{($country->id==$user->country_id)?'selected':''}} >
                                                                        <a href="javascript:;"
                                                                           data-value="{{$country->id}}">{{$country->code.' +'.$country->zipCode}}</a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                            <input type="hidden"
                                                                   value="{{sizeof($countries)?$countries[0]->id:''}}"
                                                                   class="drop_sel" id="mobile_country_id"
                                                                   name="mobile_country_id"/>
                                                        </div>
                                                    </div>
                                                    <h3 class="AcMo hidden"
                                                        style="display: {{$user->mobileConfirm?'none':'block'}}">الهاتف
                                                        غير مفعل ولتفعيله</h3>
                                                    <button class="AcMo hidden"
                                                            style="display: {{$user->mobileConfirm?'none':'block'}}"
                                                            id="active_phone">إضغط هنا <i class="fa fa-spin fa-spinner "
                                                                                          style="display: none"
                                                                                          id="LoaderPhone"></i></button>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <h2> تاريخ الميلاد<span class=" ft-15" aria-required="true"> * </span>
                                                </h2>
                                            </div>
                                            <?php
                                            if ($user->DOB) {
                                                $date = \Carbon\Carbon::parse($user->DOB);
                                                $haveDOB = true;
                                            } else
                                                $haveDOB = false;
                                            ?>
                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                <div class="selects2 sadwe">
                                                    <div class="dropdown">
                                                        <button class="btn dropdown-toggle" type="button"
                                                                data-toggle="dropdown">{{($haveDOB)?$date->day:1}}
                                                            <span class="caret"></span></button>
                                                        <ul class="dropdown-menu">
                                                            @for($i=1 ;$i<=31;$i++)
                                                                <li><a href="javascript:;"
                                                                       data-value="{{$i}}">{{$i}}</a></li>
                                                            @endfor
                                                        </ul>
                                                        <input class="{{$errors->has('day')?'input-has-error':''}}"
                                                               type="hidden" placeholder=" تاريخ الميلاد"
                                                               value="{{($haveDOB)?$date->day:1}}" class="drop_sel"
                                                               name="day"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                <div class="selects2 sadwe">
                                                    <div class="dropdown">
                                                        <button class="btn dropdown-toggle" type="button"
                                                                data-toggle="dropdown">{{($haveDOB)?$date->month:1}}
                                                            <span class="caret"></span></button>
                                                        <ul class="dropdown-menu">
                                                            @for($i=1 ;$i<=12;$i++)
                                                                <li><a href="javascript:;"
                                                                       data-value="{{$i}}">{{$i}}</a></li>
                                                            @endfor
                                                        </ul>
                                                        <input class="{{$errors->has('month')?'input-has-error':''}}"
                                                               type="hidden" value="{{($haveDOB)?$date->month:1}} "
                                                               class="drop_sel" name="month"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                <div class="selects2 sadwe">

                                                    <?php $currentYear = $i = date('Y') ?>
                                                    <?php $fromYear = 1950; ?>

                                                    <div class="dropdown">
                                                        <button class="btn dropdown-toggle" type="button"
                                                                data-toggle="dropdown">{{($haveDOB)?$date->year:$currentYear}}
                                                            <span class="caret"></span></button>
                                                        <ul class="dropdown-menu">

                                                            @while($fromYear<=$i)
                                                                <li><a href="javascript:;"
                                                                       data-value="{{$i}}">{{$i--}}</a></li>
                                                            @endwhile
                                                        </ul>
                                                        <input class="{{$errors->has('year')?'input-has-error':''}}"
                                                               type="hidden"
                                                               value="{{($haveDOB)?$date->year:$currentYear}} "
                                                               class="drop_sel" name="year"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="info_perfs">
                                                    <h2 style="margin: 0;">الجنس<span class=" ft-15"
                                                                                      aria-required="true"> * </span>
                                                    </h2>
                                                    <div class="slideTows">
                                                        <input type="radio" value="1" id="genderMale"
                                                               {{($user->gender==1)?'checked':''}} name="gender"/>
                                                        <label for="genderMale">ذكر</label>
                                                    </div>
                                                    <div class="slideTows"
                                                         class="{{$errors->has('gender')?'input-has-error':''}}">
                                                        <input type="radio" value="2" id="genderFemale"
                                                               {{($user->gender==2)?'checked':''}} name="gender"/>
                                                        <label for="genderFemale">انثى</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div id="imageMsg"></div>
                                        <div class="img_prof_asd">
                                            <div class='myLoader1'><i class='fa fa-spin fa-spinner'></i></div>
                                            <img class="img_prof_asdimg avatarImage" id="avatarImage"
                                                 src="{{avatar($user->avatar,$setting)}}">
                                            <ul>
                                                <li>
                                                    <input type="file" id="file_img" accept="image/*">
                                                    <input type="text" name="avatar" value="{{$user->avatar}}"
                                                           id="avatar_name">
                                                    <label for="file_img"> رفع صورة <i id="uploadLoader"
                                                                                       class="fa fa-spin fa-spinner uploadLoader1 hidden"></i></i>
                                                    </label>
                                                </li>
                                                <li>
                                                    <button id="deleteAvatar"><i class="icon-delete"></i>حذف الصورة
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="heade_div2">
                                <h2>معلوماتي</h2>
                            </div>
                            <div class="item_sc2">
                                <?php $specialization_id = $user->specialization_id ? $user->specialization_id : 0?>
                                <h2 style="margin: 0;">النبذة التعريفية</h2>
                                <div class="editTextarea">
                                    <textarea rows=6 palceholder='اكتب نبذة عن نفسك'
                                              name='Brief'>{{$user->Brief}}</textarea>
                                </div>
                                <h2>التخصص</h2>
                                <div class="selects2 phpasd">
                                    <select name="specialization_id" class='specialization'>
                                        <option value="0">اختر تخصص</option>
                                        @foreach($specializations as $specialization)
                                            <option value="{{$specialization->id}}" {{$specialization->id==$specialization_id?'selected':''}}>{{$specialization->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <h2 style="margin-top: 25px;">المهارات</h2>
                                <div class="editErrorSkills">
                                    <select class="js-example-basic-multiple" name="skills[]" id="skillsinput"
                                            multiple="multiple">
                                        @if($specialization_id)
                                            @foreach($specializations->keyBy('id')[$specialization_id]->skills as $skill)
                                                <option class="skillOption"
                                                        value="{{$skill->id}}" {{in_array($skill->id,$hasSkills)?'selected':''}}>{{$skill->name}}</option>
                                            @endforeach
                                        @else
                                            <option class="skillOption">اختر التخصص اولا</option>

                                        @endif
                                    </select>
                                </div>
                            </div>
                            <!--                         <div class="heade_div2">
                                                        <h2>نبذة عني </h2>
                                                    </div> -->
                            <!--                         <div class="item_sc2">

                                                    </div> -->
                            @if(!$user->isSocial)
                                <div class="heade_div2">
                                    <h2>تغيير كلمة المرور</h2>
                                </div>
                                <div class="item_sc2">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <h2>كلمة المرور الحالية</h2>
                                            <input type="password" class="empty" name="currentPassword"
                                                   placeholder="كلمة المرور الحالية">
                                        </div>
                                        <div class="col-md-4">
                                            <h2>كلمة المرور الجديدة</h2>
                                            <input type="password" minlength="5" class="empty" name="newPassword"
                                                   placeholder="كلمة المرور الجديدة">
                                        </div>
                                        <div class="col-md-4">
                                            <h2>تكرار كلمة المرور الجديدة</h2>
                                            <input type="password" minlength="5" class="empty"
                                                   name="newPassword_confirmation"
                                                   placeholder="تأكيد كلمة المرور الجديدة">
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-12">
                                <div class="btn_ok">
                                    <button type="submit"> حفظ <i class="fa fa-spin fa-spinner hidden"
                                                                  id="formLoader"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-4">
                    {{-- @include('front.sidePortfolio') --}}
                    @include('front.userSteps')
                </div>
            </div>
        </div>
    </section>
    <section class="get_some_error">
        <div class="bg_get_some_error"></div>
        <div class="get_some_error_item">
            <div class="heade_div2">
                <h2>تفعيل رقم الجوال</h2>
                <button class="close_get_some"><i class="icon-delete"></i></button>
            </div>
            <div class="item_get_some">
                <form action="/verfiedCode" id="verfiedCode" method="post">
                    <h2>كود التفعيل<span>*</span></h2>
                    <input type="text" required="" name="code">
                    <button id="activateSubmit" type="submit" class="item_get_somebutton">تفعيل <i
                                class="fa fa-spinner fa-spin" style="display: none" id="ActivateLoader"></i></button>
                </form>
            </div>
        </div>
    </section>
    <style>
        .select2-results__options {
            float: right;
            width: 100%;
        }

        .selects3:after, .selects3s:after, .selects2:after, .selects4:after, .selectss:after {
            display: none;
        }

        .myLoader1 {
            width: 100%;
            height: 100%;
            font-size: 50px;
            z-index: 999;
            float: right;
            position: absolute;
            color: #fe5339;
            padding-right: 30%;
            padding-top: 30%;
            display: none;
        }
    </style>
@endsection
@section('script')
    <script>
        $(".js-example-basic-multiple").select2({
            placeholder: "الرجاء الاختيار",
            dir: "rtl"
        });
        $('.specialization').select2({
            placeholder: "الرجاء الاختيار",
            dir: "rtl"
        });


//        var th =  $('.select-country').find('li');
//        var sel_val = th.find('a').attr('data-value');
//
//
//        console.log(sel_val);
        $('.select-country').find('li').click(function () {
            var th = $(this);
            var sel_val = th.find('a').attr('data-value');
            console.log(sel_val);
            var c_ele=$('.select-country-code');
            var cods = c_ele.find('li');
            cods.removeAttrs('selected');
            var par_search= cods.find('a[data-value=' + sel_val + ']').parent('li')
            par_search.attr('selected', '');
            c_ele.find('.dropdown-toggle').text(par_search.find('a').text())
        });
        var ajax_obj;
        var Loader;
        $('#mobile').change(function () {
            $('.AcMo').show();
            $('#phoneAcSp').html('<span class="not_active">غير مفعل</span>');
        });
        $('#verfiedCode').submit(function (e) {
            e.preventDefault();

            $(this).attr('disabled', true);
            ajax_obj = $('#activateSubmit');
            Loader = $('#ActivateLoader');
            Loader.show();
            $.ajax({
                url: '/checkMobileCode',
                data: $(this).serialize()
            }).done(function (data) {
                if (data.status) {
                    nofication_good('تم تفعيل رقم الجوال');
                    $('#verfiedCode').children('input').val('');
                    $('.AcMo').hide();
                    $('#phoneAcSp').html('<span class="phone_active">مفعل</span>');
                    $('#mobile').attr('disabled', true);
                } else {
                    nofication_error(data.msg);
                }
            }).complete(function () {
                Loader.hide();
                ajax_obj.attr('disabled', false);
            })
        });
        $('#active_phone').click(function (e) {
            e.preventDefault();
            $(this).attr('disabled', true);
            ajax_obj = $(this);
            Loader = $('#LoaderPhone');
            Loader.show();
            $.ajax({
                url: '/sendActivaeMobile',
                data: 'mobile_country_id=' + $('#mobile_country_id').val() + '&mobile=' + $('#mobile').val()
            }).done(function (data) {

                if (data.status) {
                    $('.get_some_error').show();
                } else {
                    nofication_error(data.msg);
                }
            }).complete(function () {
                Loader.hide();
                ajax_obj.attr('disabled', false);
            })
        });
        var imageUploading = false;
        $('#file_img').change(function (e) {
            e.preventDefault();
            if (!imageUploading && $(this).val()) {
                imageUploading = true;
                $('#uploadLoader').removeClass('hidden');
                url = 'uploadImage';
                formData = new FormData();
                formData.append('file', e.target.files[0]);
                formData.append('_token', '{{csrf_token()}}');
                $.ajax({
                    method: "POST",
                    url: url,
                    dataType: 'json',
                    data: formData,
                    async: true,
                    processData: false,
                    contentType: false,
                    success: function (data, textStatus, jqXHR) {
                        if (!data.status)
                            showMsg(data.msg, 'danger', 'imageMsg');
                        else {
                            $('.avatarImage').attr('src', '/image_r/200/' + data.filename);
                            $('#avatar_name').val(data.filename);

                        }
                        imageUploading = false;

                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        showMsg(textStatus);
                    },
                    complete: function (data, status) {
                        imageUploading = false;
                        $('#uploadLoader').addClass('hidden');
                    }
                });
            }
        });
        $('#editProfile').validate();
        var editClick = false;
        $('#editProfile').submit(function (e) {
            e.preventDefault();
            if ($('#skillsinput').val()) {
                if (!editClick && $('#editProfile').valid()) {
                    if (!imageUploading) {
                        editClick = true;
                        $('#formLoader').removeClass('hidden');
                        url = $(this).attr('action');
                        $.ajax({
                            method: "POST",
                            url: url,
                            dataType: 'json',
                            data: $(this).serialize(),
                            success: function (data, textStatus, jqXHR) {
                                if (!data.status)
                                    showMsg(data.msg);

                                else {
                                    if (data.emailStatus == 1) {
                                        showMsg(data.msg, 'success');
                                    } else {
                                        showMsg('تم تعديل الملف الشخصي', 'success');
                                        location.reload();
                                    }

                                    $('.fullname').text(data.fullname);
                                    $('.empty').val('');
                                }
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                showMsg(textStatus);
                            },
                            complete: function (data, status) {
                                editClick = false;
                                $('#formLoader').addClass('hidden');
                            }
                        });
                    } else {
                        myNoty('الرجاء انتظار رفع الصورة الشخصية');
                    }
                }
            } else {
                showMsg('الرجاء اختيار مهارة واحدة على الأقل');
            }
        });
        $('.checkUserName').focusout(function () {
            $.ajax({
                url: '/checkUserName/' + $(this).val()
            }).done(function (data) {
                if (data.status) {
                    $('.username-check').removeClass('hidden');
                    $('.username-close').addClass('hidden');
                } else {
                    nofication_error(data.msg);
                    $('.username-close').removeClass('hidden');
                    $('.username-check').addClass('hidden');

                }
            });
        });
        $('#deleteAvatar').click(function (e) {
            if (!imageUploading) {
                e.preventDefault();
                if (!imageUploading) {
                    imageUploading = true;
                    $('#uploadLoader').removeClass('hidden');
                    url = 'deleteImage';
                    $.ajax({
                        method: "GET",
                        url: url,
                        dataType: 'json',
                        success: function (data, textStatus, jqXHR) {
                            if (!data.status)
                                showMsg(data.msg, 'danger', 'imageMsg');
                            else {
                                $('#avatar_name').val('');
                                $('.avatarImage').attr('src', data.filename);
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            showMsg(textStatus);
                        },
                        complete: function (data, status) {
                            imageUploading = false;
                            $('#uploadLoader').addClass('hidden');
                        }
                    });
                }
            }
        });
    </script>
@endsection