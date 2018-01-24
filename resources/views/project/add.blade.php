<?php global $setting; ?>
@extends('front.__template')
@section('title','اضافة مشروع جديد')
@section('content')
<style>
    #myDrop  label,#multipleFile label {
        font-size: 12px;
        color: #fff;
        padding: 8px 20px;
        border-radius: 30px;
        background: #fe5339;
        display: inline-block;
        cursor: pointer;
        width: 160px;
        max-width: 100%;
        position: absolute;
        margin: auto;
        top: 38%;
        left: 0;
        right: 0;
        -webkit-box-shadow: 0px 20px 30px 0px rgba(168, 172, 185, 0.4);
        -moz-box-shadow: 0px 20px 30px 0px rgba(168, 172, 185, 0.4);
        box-shadow: 0px 20px 30px 0px rgba(168, 172, 185, 0.4);
        text-align: center;
    }
    .item_protfolio input, .item_protfolio textarea {
        font-size: 14px;
    }
    label.error{
        display: none!important;
    }
    input.error,textarea.error{
        border-color:red!important;
    }
    .all_widas {
         margin-bottom: 30px;
    }
    .specialization1{
        position: relative;
        bottom: 5px;
    }
    .dropzone .dz-preview .dz-error-message {
        top: 113px !important;
        left: -5px !important;
    }
    .dropzone .dz-preview.dz-image-preview {
        width: 130px !important;
        height: 130px !important;
    }
    .dz-preview .dz-image{
        background: #ddd !important;
    }
    .dz-preview .dz-image img{
        background : #fff;
        margin : 15px 5px 0px 15px;
        width : 100px !important;
        height : 100px !important;
        border-radius : 10px;
        padding:10px;
        margin : 15px 5px 0px 15px;
    }
    .dz-preview .dz-image img:first-of-type {
        margin : 15px 15px 0px 15px;
    } 
  .item_protfolio h2 {
    font-size: 14px;
}
</style>
<section class="s_protfolio">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="all_item_profsingle">
                    <div class="heade_div2">
                        <h2>أضف مشروع</h2>
                    </div>
                    <form id="handleAddProject" action="handleAddProject" method="post">
                        <div class="item_protfolio">
                            <div class="row">
                                <div class="col-md-9 col-sm-8" style="margin-bottom: 15px;">
                                    <h2>عنوان المشروع</h2>
                                    <input type="text" placeholder="أضف عنوان المشروع" name="title" required>
                                </div> 

                                <div class="col-md-3 col-sm-4">
                                    <h2>ميزانية المشروع</h2>
                                    <div class="selects2">
                                        <div class="dropdown rd_bgw">
                                            <button style="padding: 9px;" class="btn dropdown-toggle" type="button" data-toggle="dropdown">{{sizeof($projectbudget)?('$'.$projectbudget[0]->min.'-$'.$projectbudget[0]->max):''}}
                                                <span class="caret"></span></button>
                                                <ul class="dropdown-menu" style="height: 50vh;overflow-y: scroll;">
                                                @foreach($projectbudget as $value)
                                                <li><a href="javascript:;" data-value="{{$value->id}}">{{'$'.$value->min.'-$'.$value->max}}</a></li>
                                                @endforeach
                                            </ul>
                                            <input type="hidden" value="{{sizeof($projectbudget)?$projectbudget[0]->id:''}}" class="drop_sel" name="budget_id" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                                @if(session('user')['isVIP'])
                                <div class=" specialization1">
                                    <h2>صاحب المشروع</h2>
                                    <div class="selects2 phpasd">
                                        <select name="projectOwner_id" class='specialization'>
                                            @foreach($users as $user)
                                            <option value="{{$user->id}}" >{{$user->fullname()}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @endif
                            <h2>وصف مشروع</h2>
                            <textarea rows="6" required placeholder="أضف وصف المشروع" name="description"></textarea>
                                <div class="specialization1">
                                    <h2>التخصص</h2>
                                    <div class="selects2 phpasd">
                                        <select name="specialization_id" class='specialization'>
                                            @foreach($specializations as $specialization)
                                            <option value="{{$specialization->id}}" {{$specialization->id==$user->specialization_id?'selected':''}}>{{$specialization->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="all_widas">
                                        <h2>المهارات المطلوبة</h2>
                                        <select class="js-example-basic-multiple" id="skillsinput" required name="skills[]" multiple="multiple">
                                            @foreach($specializations[0]->skills as $skill)
                                            <option value="{{$skill->id}}">{{$skill->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="all_widas">
                                        <h2>مدة التسليم بالايام <span>*</span></h2>
                                        <div class="plus_input">
                                            <span class="input-group-btn mins">
                                                <button type="button" class="btn btn-default btn-number minus" data-type="project-day">
                                                    <span class="glyphicon glyphicon-minus"></span>
                                                </button>
                                            </span>
                                            <input type="number" name="deliveryDuration" required class="input-number project-day" value="1"  maxlength="4" min="1">
                                            <span class="input-group-btn plusq">
                                                <button type="button" class="btn btn-default btn-number plus" data-type="project-day">
                                                    <span class="glyphicon glyphicon-plus"></span>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="plus_input_drag">
                                        <h2>صور مرفقة (توضيحية)</h2>
                                        <div class=" drop" id="multipleFile">
                                            <div class="dz-default dz-message" data-dz-message="jl">
                                                <div class="multipleButton">
                                                    <label for="" id="">إختر ملف<i class="fa fa-spin fa-spinner hidden" id="multipleLoader"></i></label>
                                                    <h3>سحب وإفلات الملفات هنا</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="img_addqw">
                                        <h2>الملفات المرفوعة</h2>
                                        <ul id="fileList" class="dropzone">


                                            <li class="hidden">
                                                <div class="img_first_notadd">
                                                    <input type="file" name="" id="cycleDocsument" class="uploadSingleImage"/>
                                                    <label for="cycleDocsument"><i class="icon-plus"></i></label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="btn_ok">
                                        <button>نشر المشروع <i class='fa fa-spin fa-spinner hidden' id='formLoader'></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                @include('.project.addSide')
            </div>
        </div>
    </div>
</section>
<style>
    .select2-results__options{
        float: right;
        width: 100%;
    }
    .selects2.phpasd:after {
        display: none;
    }

    .select2-container--default .select2-selection--single{
        border: 1px solid #f3f4f5;
    }
    .specialization1{
    padding-top: 15px;
    padding-bottom: 25px;
    float: right;
    width: 100%;
    }
</style>
@endsection
@section('script')
<link rel="stylesheet" href="https://rawgit.com/enyo/dropzone/master/dist/dropzone.css">
<script>
$(".js-example-basic-multiple").select2({
    placeholder: "الرجاء الاختيار",
    dir: "rtl"
});
$('.specialization').select2({
    placeholder: "الرجاء الاختيار",
    dir: "rtl"
});
var files = 0;
var ajaxUpload = 0;
var ajaxFinish = 0;
Dropzone.autoDiscover = false;
var drobzoneFile = new Dropzone("div#multipleFile", {
    url: "/upload",
    paramName: "file", // The name that will be used to transfer the file
    maxFilesize: 10, // MB
    addRemoveLinks: true,
    acceptedFiles: '{{getFileType('project')}}',
    previewsContainer: '.dropzone',
    dictFallbackMessage:'هذا المتصفح لا يدعم السحب والافلات',
    dictFallbackText:'اسحب الملفات هنا',
    dictInvalidFileType:'هذا الملف غير مدعوم',
    dictFileTooBig:'حجم الملف أكبر من الحد الأقصى للملفات',
    dictCancelUpload:'',
    dictCancelUploadConfirmation:'هل انت متأكد من الغاء الرفع',
    dictRemoveFile:'',
    dictMaxFilesExceeded:'لقد تجاوزت الحد الأقصى للملفات المرفوعة',
    maxFiles :15,
    accept: function (file, done) {
        done();
    },
    init: function () {
        this.on("addedfile", function (file) {
            files++;
        
            var ext = file.name.split('.').pop().toLowerCase();
            var filePreview = $(file.previewElement).find(".dz-image img");
            
            if (ext == "pdf") {
                filePreview.attr("src", "/icons/pdf.png").css('padding', '5px');
            } else if (ext.indexOf("doc") != -1) {
                filePreview.attr("src", "/icons/word.png").css('padding', '10px 15px');
            } else if (ext.indexOf("ppt") != -1) {
                filePreview.attr("src", "/icons/ppt.png").css('padding', '12px 15px');
            } else if (ext.indexOf("zip") != -1 || ext.indexOf("rar") != -1) {
                filePreview.attr("src", "/icons/compressed.png");
            } else if (ext.indexOf("txt") != -1) {
                filePreview.attr("src", "/icons/txt.png");
            } else if (ext.indexOf("xls") != -1) {
                filePreview.attr("src", "/icons/excel.png");
            } else {
                filePreview.attr("src", "/icons/other.png");
            }
            
        });

        this.on("success", function (file, data) {
            ajaxFinish++;
            if (data.status) {
                file._titleBox = Dropzone.createElement("<input value='" + data.file_id + "' type='hidden' class='hiddenInput' name='files[]' >");
                file.previewElement.appendChild(file._titleBox);

            } else {
                nofication_error(data.msg);
            }
        });
        this.on("canceled", function (file) {
        ajaxUpload--;
          
        });
        this.on("removedfile", function (file) {
            file_id = $(file.previewElement.querySelector('.hiddenInput')).val();
            $.ajax({
                url: 'deleteFile/' + file_id,
                dataType: 'json'
            });
            ajaxUpload--;
            ajaxFinish--;
        });
        this.on("dictRemoveFile", function (file) {

        });
        this.on("sending", function (file, xhr, data) {
            ajaxUpload++;
            data.append("_token", "<?= csrf_token() ?>");
        });
    },

});
$('form').validate({
    rules: {
        "skills[]": {
            minlength: 1
        }
    }
});
var addClick = false;
$('#handleAddProject').submit(function (e) {
    e.preventDefault();
    if (!addClick && $(this).valid()) {
        if ($('#skillsinput').val()) {
            if (ajaxUpload != ajaxFinish) {
                nofication_error('الرجاء انتظار رفع الصور');
                return;
            }
            if (!addClick && $('form').valid()) {
                addClick = true;
                $('#formLoader').removeClass('hidden');
                url = $(this).attr('action');
                $.ajax({
                    method: "POST",
                    url: url,
                    dataType: 'json',
                    data: $(this).serialize() + '&_token=' + '<?= csrf_token() ?>',
                    success: function (data, textStatus, jqXHR) {
                        if (!data.status) {
                            nofication_error(data.msg);
                            addClick = false;
                        } else {
                            nofication_good('تم اضافة المشروع بانتظار موافقة الإدارة');
                            setTimeout(function () {
                                window.location = '/myProjects';
                            }, 3000);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        myNoty('حصل خطأ ما الرجاء المحاولة فيما بعد');
                    },
                    complete: function (data, status) {
                        addClick = false;
                        $('#formLoader').addClass('hidden');
                    }
                });
            }
        } else {
            nofication_error('الرجاء اختيار مهارة واحدة على الأقل');
        }
    }
});
$('body').on('click', '.deleteFile', function (e) {
    e.preventDefault();
    elm = $(this).parent().parent();
    $.ajax({
        url: 'deleteFile/' + elm.children('input').val(),
        dataType: 'json'
    }).done(function () {
        elm.parent().remove();
        $('#multipleFile .dz-image-preview').empty();
        $('#multipleFile .multipleButton').css('display', 'block');
        $('#multipleFile .multipleButton h3').css('display', 'block');
    });
});
var uploadSingleImage = false;
$('.uploadSingleImage').change(function () {
    if (ajaxUpload != ajaxFinish) {
        nofication_error('الرجاء انتظار رفع الصور');
        return;
    }
    if (!uploadSingleImage) {
        uploadSingleImage = true;
        var loader = $(this).parent().children('label').children('i');
        loader.removeClass('icon-plus');
        loader.addClass('fa fa-spinner fa-spin');

        url = 'upload';
        formData = new FormData();
        formData.append('file', $(this)[0].files[0]);
        formData.append('_token', '{{csrf_token()}}');
        $.ajax({
            method: "POST",
            url: url,
            dataType: 'json',
            data: formData,
            async: false,
            processData: false,
            contentType: false,
            success: function (data, textStatus, jqXHR) {
                if ((data.status)) {
                    if (data.type == 'file') {
                        var im = '/front/images/file.png';
                    } else {
                        var im = 'image_r/200/' + data.file_name;
                    }
                    var html = "<li>" +
                            "<div class='img_first_add'>" +
                            "<img src='" + im + "'>" +
                            "<input type='hidden' name='files[]' value='" + data.file_id + "'>" +
                            "<div class='bg_this_img'>" +
                            "<a href='#' class='deleteFile' '><i class='icon-delete'></i></a>" +
                            "</div>" +
                            "</div>" +
                            "</li>";
                    $('#fileList').prepend(html);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(textStatus);
            },
            complete: function (data, status) {
                uploadSingleImage = false;
                loader.addClass('icon-plus');
                loader.removeClass('fa fa-spinner fa-spin');
            }
        });

    } else {
        nofication_error('الرجاء انتظار رفع الصور');
    }

});
</script>
@endsection