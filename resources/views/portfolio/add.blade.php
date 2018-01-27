@extends('front.__template')
@section('title','اضافة عمل')
<link rel='stylesheet' href='public/front/css/bootstrap-datetimepicker.css'>
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
    .item_protfolio h2 {
        font-size: 14px;
    }
    label.error{
        display: none!important;
    }
    input.error,textarea.error{
        border-color:red!important;
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
    label.error{
        font-size: 12px;
        position: relative;
        /* float: left; */
        text-align: left;
        bottom: 57px;
        float: left;
    }
    .bg_this_img a {
      padding:8px;
    }
  
    input.error,textarea.error{
        border-color:red!important;
    }
    .portoflio-fav .dz-preview .dz-image img:first-of-type {
        width: 100% !important;
        height: 100% !important;
        margin: 0;
    }
    .portoflio-fav .dropzone .dz-preview.dz-image-preview {
        height: 89% !important;
        width: 101% !important;
    }
    .portoflio-fav .dropzone .dz-preview .dz-image {
        height: 100% !important;
        width: 100% !important;
        border-radius: 0px !important;
        z-index: 0 !important;
    }
    </style>
    <?php global $setting; ?>
    <section class="s_protfolio adds">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="all_item_profsingle">
                        <div class="heade_div2">
                            <h2>اضافة عمل جديد</h2>
                        </div>
                        <form action="/handleAddPortfolio" id="handleAddPortfolio" >
                            {{csrf_field()}}
                             <div class="item_protfolio">
                                 <div id="msg"></div>
                                 <div>
                            <h2>عنوان العمل</h2>
                            <input type="text" required  name="title"  placeholder="أضف عنوان العمل" >
                                 </div>

                                 <div>
                                     <h2>رابط العمل</h2>
                                     <input type="text" required  name="url"  placeholder="أضف رابط العمل" >
                                 </div>

                                 <div class="">
                                     <h2>وصف العمل</h2>
                                         <textarea rows="6"  required name="description" placeholder="أضف وصف العمل"></textarea>
                                     </div>
                                     <div class="row">
                                <div class="col-md-9">
                                    <div class="all_widas">
                                    <h2>المهارات التي إستخدمتها في عملك</h2>
                                    <select class="js-example-basic-multiple" id="skillsinput" name="skills[]" multiple="multiple">
                                       @foreach($skills as $skill)
                                           <option value="{{$skill->id}}">{{$skill->name}}</option>
                                       @endforeach
                                    </select>
                                </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="all_widas">
                                    <h2>تاريخ الإنجاز<span>*</span></h2>
                                    <div class="calendarsq">
                                        <input type='text' required id='datetimepicker4' name="accomplishDate" value="<?=date('y-m-d')?>" />
                                    </div>
                                </div>
                                </div>
                                <div class="col-md-6">
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
                                <div class="col-md-6 portoflio-fav">
                                    <div class="plus_input_drag Thumbnail">
                                        <h2>صورة مصغرة للعمل</h2>
                                        <input type="hidden" name="Thumbnail" id="Thumbnail">
                                        <div class=" dropzone drop" id="myDrop">
                                            <div class="dz-default dz-message" data-dz-message="jl">
                                                <div class="thumpnailButton">
                                                    <label for="" id="">إختر صورة<i class="fa fa-spin fa-spinner hidden thumpnailLoader" id="thumpnailLoader"></i></label>
                                                    <h3>سحب وإفلات الملفات هنا</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 hdx2">
                                    <div class="img_addqw">
                                        <h2>الصور المرفوعة</h2>
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
                                        <button type="submit">نشر العمل  <i class="fa fa-spin fa-spinner hidden" id='formLoader'></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
               {{--  <div class="col-md-4">
                    @include('front.mySidebar')
                    @include('front.statistic')
                </div> --}}
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script>
        var thumpnailFileName='';
        var isUploadAvatar=false;
        var isUploadedAvatar=false;
        var myDropzone = new Dropzone("div#myDrop", {
            url: "/upload",
            acceptedFiles: '{{getFileType('portfolio')}}',
            addRemoveLinks:true,
            paramName: "file", // The name that will be used to transfer the file
            uploadMultiple:false,
            maxFiles:1,
            maxFilesize: 10, // MB
            dictFallbackMessage:'هذا المتصفح لا يدعم السحب والافلات',
            dictFallbackText:'اسحب الملفات هنا',
            dictInvalidFileType:'هذا الملف غير مدعوم',
            dictFileTooBig:'حجم الملف أكبر من الحد الأقصى للملفات',
           dictCancelUpload:'',
//     dictCancelUploadConfirmation:'هل انت متأكد من الغاء الرفع',
    dictRemoveFile:'',
            dictMaxFilesExceeded:'لقد تجاوزت الحد الأقصى للملفات المرفوعة',
            accept: function (file, done) {
                    done();
            },
            init: function () {
                this.on("addedfile", function(file) {
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
               this.on("maxfilesexceeded", function(file) {
                        this.removeAllFiles();
                        this.addFile(file);
                  });
                this.on("success", function (file, data) {
                    $('#Thumbnail').val(data.file_name);
                    $('#Thumbnail .dz-image img').attr('src', 'image_r/200x100/'+data.file_name);
                    thumpnailFileName=data.file_name;
                    isUploadAvatar=true;
                    isUploadedAvatar=false;
                });
                this.on("removedfile", function (file) {
                      isUploadAvatar=false;
                       $('#Thumbnail').val('');

                        $.ajax({
                        url:'deleteFile/'+thumpnailFileName,
                        dataType:'json'
                            }).done(function(){
                              
                            });
                });
                this.on("dictRemoveFile", function (file) {

                });
                this.on("sending", function(file, xhr, data) {
                    if (this.files[1]!=null){
                        this.removeFile(this.files[0]);
                    }
                    isUploadedAvatar=true;
                    data.append("_token", "<?=csrf_token()?>");
                });
            },
        });
        Dropzone.autoDiscover = false;
        var uploadeFils=0;
        var uploadedFile=0;
        var drobzoneFile = new Dropzone("div#multipleFile", {
            url: "/upload",
            addRemoveLinks:true,
            previewsContainer:'#fileList',
            acceptedFiles: '{{getFileType('portfolio')}}',
            paramName: "file", // The name that will be used to transfer the file
            maxFilesize: 10, // MB
            dictFallbackMessage:'هذا المتصفح لا يدعم السحب والافلات',
    dictFallbackText:'اسحب الملفات هنا',
    dictInvalidFileType:'هذا الملف غير مدعوم',
    dictFileTooBig:'حجم الملف أكبر من الحد الأقصى للملفات',
dictCancelUpload:'',
//     dictCancelUploadConfirmation:'هل انت متأكد من الغاء الرفع',
    dictRemoveFile:'',
    dictMaxFilesExceeded:'لقد تجاوزت الحد الأقصى للملفات المرفوعة',
            init: function () {
                this.on("addedfile", function(file) {
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
                    addClick=false;
                    uploadedFile++;
                    	file._titleBox = Dropzone.createElement("<input value='"+data.file_id+"' type='hidden' class='hiddenInput' name='files[]' >");

                        file.previewElement.appendChild(file._titleBox);

                        if(data.type=='file') {
                        var im= '/front/images/file.png';
                    }else{
                        var im= 'image_r/200/'+data.file_name;
                    }
                        var html="<li>"+
                           "<div class='img_first_add'>"+
                                "<img src='"+im+"'>"+
                                        "<input type='hidden' name='files[]' value='"+data.file_id+"'>"+
                                "<div class='bg_this_img'>"+
                                    "<a href='#' class='deleteFile' '><i class='icon-delete'></i></a>"+
                                "</div>"+
                            "</div>"+
                        "</li>";    
                });
                this.on("removedfile", function (file) {
                    file_id=$(file.previewElement.querySelector('.hiddenInput')).val();
                      $.ajax({
                            url:'deleteFile/'+file_id,
                            dataType:'json'
                        });
                        uploadeFils--; uploadedFile--;
                    console.log(file_id);
                });
                this.on("dictRemoveFile", function (file) {

                });

                this.on("sending", function(file, xhr, data) {
                 uploadeFils++;
                    data.append("_token", "<?=csrf_token()?>");
                });
            },
        });
        $(".js-example-basic-multiple").select2({
            placeholder: "الرجاء الاختيار",
            dir: "rtl"
        });
         $('#datetimepicker4').datetimepicker({
           format: 'YYYY-MM-DD'
         });
        $('body').on('click','.deleteFile',function (e) {
            e.preventDefault();
            elm=$(this).parent().parent();
            $.ajax({
                url:'deleteFile/'+elm.children('input').val(),
                dataType:'json'
            }).done(function(){
                elm.parent().remove();
                $('#multipleFile .dz-image-preview').empty();
                $('#multipleFile .multipleButton h3').css('display','block');
            });
        });
        var uploadSingleImage=false;
        $('.uploadSingleImage').change(function(){
            if(!uploadSingleImage){
                uploadSingleImage=true;
                var loader=$(this).parent().children('label').children('i');
                loader.removeClass('icon-plus');
                loader.addClass('fa fa-spinner fa-spin');
                url='upload';
                formData=new FormData();
                formData.append('file',$(this)[0].files[0]);
                formData.append('_token','{{csrf_token()}}');
                $.ajax({
                    method: "POST",
                    url: url,
                    dataType:'json',
                    data: formData,
                    async:false,
                    processData: false,
                    contentType: false,
                    success: function (data, textStatus, jqXHR) {
                        if((data.status)){
                            if(data.type=='file') {
                                var im= '/front/images/file.png';
                            }else{
                                var im= 'image_r/200/'+data.file_name;
                            }
                        var html="<li>"+
                                "<div class='img_first_add'>"+
                                "<img src='"+im+"'>"+
                                "<input type='hidden' name='files[]' value='"+data.file_name+"'>"+
                                "<div class='bg_this_img'>"+
                                "<a href='#' class='deleteFile' '><i class='icon-delete'></i></a>"+
                                "</div>"+
                                "</div>"+
                                "</li>";
                        $('#fileList').prepend(html);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert(textStatus);
                    },
                    complete: function (data, status) {
                        uploadSingleImage=false;
                        loader.addClass('icon-plus');
                        loader.removeClass('fa fa-spinner fa-spin');
                    }
                });
            }
        });
        $('form').validate();
        var addClick=false;
        $('#handleAddPortfolio').submit(function(e){
            e.preventDefault();
            if($('#skillsinput').val()) {
                if (!addClick && $('form').valid()) {

                    if(isUploadedAvatar){
                        nofication_error('الرجاء انتظار رفع الصورة المصغرة',2500);    
                    }else{
                    if(!isUploadAvatar){
                        nofication_error('الرجاء  رفع صورة مصغرة',2500);    
                        return ;
                    }
                    if(uploadedFile!=uploadeFils){
                        nofication_error('الرجاء انتظار رفع صور المشروع',2500);     
                    }else{
                         if(uploadedFile==0&&0){
                                nofication_error('الرجاء رفع صورة مرفقة على الأقل',2500);     
                            return ;
                         }
                    addClick = true;
                    $('#formLoader').removeClass('hidden');
                    url = $(this).attr('action');
                    $.ajax({
                        method: "POST",
                        url: url,
                        dataType: 'json',
                        data: $(this).serialize(),
                        success: function (data, textStatus, jqXHR) {
                            if(!data.status)
                                showMsg(data.msg);
                            else {
                                showMsg('تم اضافة العمل', 'success');
                                window.location='/portfolios';
                                addClick = true;
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            alert(textStatus);
                        },
                        complete: function (data, status) {
                            addClick = false;
                            $('#formLoader').addClass('hidden');
                        }
                    });
                }
                    }}
            }else{
                showMsg('الرجاء اختيار مهارة واحدة على الأقل');
            }
        });
    </script>
@endsection