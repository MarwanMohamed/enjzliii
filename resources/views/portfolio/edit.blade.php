 @extends('front.__template')
@section('title','تعديل العمل')

@section('content')

<link rel="stylesheet" href="https://rawgit.com/enyo/dropzone/master/dist/dropzone.css">
<link rel='stylesheet' href='/public/front/css/bootstrap-datetimepicker.css'>

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


        label.error {
            display: none !important;
        }

        input.error, textarea.error {
            border-color: red !important;
        }

        .specialization1 {
            position: relative;
            bottom: 5px;
        }
    </style>
        <?php global $setting ?>

    <section class="s_protfolio adds">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="all_item_profsingle">
                        <div class="heade_div2">
                            @if(session('user')&&session('user')['id']==$portfolio->user_id)
                                <div class="left_item_headersa">
                                    <a onclick="return confirm('are you sure?');" href="/deletePortfolio/{{$portfolio->id}}">حذف</a>
                                </div>
                            @endif
                            <h2>تعديل العمل </h2>
                        </div>
                        <form action="/handleAddPortfolio" id="handleAddPortfolio" >
                            {{csrf_field()}}
                             <div class="item_protfolio">
                                 <div id="msg"></div>
                                 <div>
                            <h2>عنوان العمل</h2>
                            <input type="text" required value="{{$portfolio->title}}"  name="title" >
                                 </div>

                                 <div>
                                     <h2>رابط العمل</h2>
                                     <input type="text" required value="{{$portfolio->url}}"  name="url" >
                                 </div>
                                 <div class="">
                                     <h2>وصف العمل</h2>
                                         <textarea rows="6"  required name="description" >{{$portfolio->description}}</textarea>
                                     </div>
                                     <div class="row">
                                <div class="col-md-9">
                                    <div class="all_widas">
                                    <h2>المهارات التي إستخدمتها في عملك</h2>
                                    <select class="js-example-basic-multiple" id="skillsinput" name="skills[]" multiple="multiple">
                                       <?php $por_skills=json_decode($portfolio->skills); ?>
                                        @foreach($skills as $skill)
                                           <option {{(array_search($skill->id,$por_skills)!==false)?'selected':''}} value="{{$skill->id}}">{{$skill->name}}</option>
                                       @endforeach
                                    </select>
                                  </div>
                                </div>
                                <div class="col-md-3">
                                    <h2>تاريخ الإنجاز<span>*</span></h2>
                                    <div class="calendarsq">
                                        <input type='text' value="{{$portfolio->accomplishDate}}" required id='datetimepicker4' name="accomplishDate"  />
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

                                <div class="col-md-12 hdx">
                                    <div class="img_addqw">
                                        <h2>الصور المرفوعة</h2>
                                        <ul id="fileList" class="dropzone ">
                                            <?php
                                            foreach ($images as $image){?>
                                            <li class="img_prev">
                                                <div class='img_first_add'>
                                                    <img src='/image/172x132/{{$image->name}}'>
                                                    <input type='hidden' name='files[]' value='{{$image->id}}'>
                                                    <div class='bg_this_img'>
                                                        <a href='#' class='deleteFile'><i class='icon-delete'></i></a>
                                                        </div>
                                                    </div>
                                            </li>
                                                <?php }?>
                                            <li class="hidden">
                                                <div class="img_first_notadd">
                                                    <input type="file" name="" id="cycleDocsument" class="uploadSingleImage"/>
                                                    <label for="cycleDocsument"><i class="icon-plus"></i></label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="plus_input_drag Thumbnail">
                                        <h2>صورة مصغرة للعمل</h2>
                                        <input type="hidden" name="Thumbnail" value="{{$portfolio->Thumbnail}}" id="Thumbnail">
                                        <div class="dropzone drop" id="myDrop">
                                            <div class="dz-default dz-message" data-dz-message="jl" style="    margin-top: 11px;">
                                                <img id="prevThumbnail" src="/image/310x170/{{$portfolio->Thumbnail}}" style="border-radius: 15px"/>
                                                <div class="thumpnailButton"   style="display: none;">
                                                    <label for="" id="">تعديل الصورة<i class="fa fa-spin fa-spinner hidden" id="thumpnailLoader"></i></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 hdx2">
                                    <div class="img_addqw">
                                        <h2>الصور المرفوعة</h2>
                                        <ul id="fileList" class="dropzone addMe">

                                            <li class="hidden">
                                                <div class="img_first_notadd">
                                                    <input type="file" name="" id="cycleDocsument" class="uploadSingleImage"/>
                                                    <label for="cycleDocsument"><i class="icon-plus"></i></label>
                                                </div>
                                            </li>
                                            <?php
                                            foreach ($images as $image){?>
                                            <li class="img_prev">
                                                <div class='img_first_add'>
                                                    <img src='/image/120x120/{{$image->name}}'>
                                                    <input type='hidden' name='files[]' value='{{$image->id}}'>
                                                    <div class='bg_this_img'>
                                                        <a href='#' class='deleteFile'><i class='icon-delete'></i></a>
                                                    </div>
                                                </div>
                                            </li>
                                            <?php }?>
                                        </ul>

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="btn_ok">
                                        <button type="submit">حفظ <i id='formLoader' class="fa fa-spin fa-spinner hidden"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-4">

                    @include('front.mySidebar')
                    @include('front.statistic')
                </div>
            </div>
        </div>
    </section>

@endsection

@section('script')
    <script>
        var thumpnailFileName='';
                var isUploadAvatar=false;

        var myDropzone = new Dropzone("div#myDrop", {
            url: "/upload",
//             previewsContainer:'#fileList',

            acceptedFiles:'{{getFileType('portfolio')}}',
            addRemoveLinks:true,
            paramName: "file", // The name that will be used to transfer the file
            uploadMultiple:false,
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
                    $('.thumpnailLoader').addClass('hidden');
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
                    $('#prevThumbnail').remove();
                    $('#thumpnailButton').children('label').text('اضافة صورة');
                    $('#Thumbnail').val(data.file_name);
                    $('#Thumbnail .dz-image img').attr('src', 'image_r/200x100/'+data.file_name);
                    thumpnailFileName=data.file_name;
                    isUploadAvatar=false;
                    isUploadedAvatar=false;

//                     var im= '/image/172x132/'+data.file_name;
//                     var html="<li>"+
//                             "<div class='img_first_add'>"+
//                             "<img src='"+im+"'>"+
//                             "<input type='hidden' name='files[]' value='"+data.file_id+"'>"+
//                             "<div class='bg_this_img'>"+
//                             "<a href='#' class='deleteFile' '><i class='icon-delete'></i></a>"+
//                             "</div>"+
//                             "</div>"+
//                             "</li>";
//                     $('#fileList').prepend(html);

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
                    isUploadAvatar=true;
                    data.append("_token", "<?=csrf_token()?>");
                });
            },

        });


        var uploadeFils=0;
        var uploadedFile=0;

        Dropzone.autoDiscover = false;

        var drobzoneFile = new Dropzone("div#multipleFile", {
            url: "/upload",
            addRemoveLinks:true,

            acceptedFiles: '{{getFileType('portfolio')}}',
            paramName: "file", // The name that will be used to transfer the file
            uploadMultiple:false,
                        previewsContainer:'.addMe',
                        dictFallbackMessage:'هذا المتصفح لا يدعم السحب والافلات',
    dictFallbackText:'اسحب الملفات هنا',
    dictInvalidFileType:'هذا الملف غير مدعوم',
    dictFileTooBig:'حجم الملف أكبر من الحد الأقصى للملفات',
    dictCancelUpload:'',
//     dictCancelUploadConfirmation:'هل انت متأكد من الغاء الرفع',
    dictRemoveFile:'',
    dictMaxFilesExceeded:'لقد تجاوزت الحد الأقصى للملفات المرفوعة',

            maxFilesize: 10, // MB
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

                this.on("success", function (file, data) {

                    addClick=false;
                    uploadedFile++;
                    	file._titleBox = Dropzone.createElement("<input value='"+data.file_id+"' type='hidden' class='hiddenInput' name='files[]' >");

                        file.previewElement.appendChild(file._titleBox);


                        var im= '/image/172x132/'+data.file_name;
                        var html="<li class='img_prev'>"+
                           "<div class='img_first_add'>"+
                                "<img src='"+im+"'>"+
                                        "<input type='hidden' name='files[]' value='"+data.file_id+"'>"+
                                "<div class='bg_this_img'>"+
                                    "<a href='#' class='deleteFile' '><i class='icon-delete'></i></a>"+
                                "</div>"+
                            "</div>"+
                        "</li>";
                    console.log('ddd');
                        $('.ddd').append(html);


                });
                this.on("removedfile", function (file) {

                });
                this.on("dictRemoveFile", function (file) {

                });

                this.on("sending", function(file, xhr, data) {
                 uploadeFils++;
//                    $('#multipleLoader').removeClass('hidden');
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
                url:'/deleteFile/'+elm.children('input').val(),
                dataType:'json'
            }).done(function(){
                elm.parent().remove();
                $('#multipleFile .dz-image-preview').empty();
                $('#multipleFile .multipleButton').css('display','block');
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

                url='/upload';
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
                                var im= '/image_r/200/'+data.file_name;
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
                    editClick = true;
                    if(isUploadAvatar){
                    myNoty('الرجاء انتظار رفع الصورة المصغرة');
                    return false;
                    }
                    if(uploadedFile!=uploadeFils){
                    myNoty('الرجاء انتظار رفع صور المشروع');
                    return false;
                    }

                    $('#formLoader').removeClass('hidden');
                    url = $(this).attr('action');
                    $.ajax({
                        method: "POST",
                        url: url,
                        dataType: 'json',
                        data: $(this).serialize()+"&id=<?=$portfolio->id?>",
                        success: function (data, textStatus, jqXHR) {
                            if(!data.status)
                                nofication_error(data.msg,3500);
                            else {
                                var html="تم تعديل العمل بنجاح ,للذهاب الى معرض الأعمال "+"<a href='/portfolios'>انقر هنا</a>"
                                nofication_good(html,15000);
                                setTimeout(function(){window.location='/portfolios';},2500);
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            alert(textStatus);
                        },
                        complete: function (data, status) {
                            editClick = false;
                            $('#formLoader').addClass('hidden');
                        }
                    });
                }
            }else{
                showMsg('الرجاء اختيار مهارة واحدة على الأقل');

            }


        });



    </script>


@endsection