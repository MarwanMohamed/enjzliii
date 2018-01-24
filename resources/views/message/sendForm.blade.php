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

    .label-mb {
        color: #fe5339;
        padding: 12px;
        font-size: 14px;
    }

    
    
</style>
@if($conversation->isBlock)
    <div class="heade_div2">
        <h2>تم حظر هذه المحادثة</h2>
    </div>
@elseif($conversation->project->isClose())
    <div class="heade_div2">
        <h2>{{$conversation->project->isClose()}}</h2>
    </div>
@else
    <div class="item_hs_ppl massagesq">

        <div class="heade_div2">
            <h2>نص الرسالة</h2>
        </div>
        <form action="javascript:;" class='form' method="post" id="sendMessage">
            {{csrf_field()}}
            <input type="hidden" name="conversation_id" value="{{$con->id}}">

            <div class="asnwer_text">
                <textarea placeholder="نص الرسالة" id="content" rows="6" name="content"
                          data-validation="required|minlength[20]"></textarea>
                <!--                         <h2>ملفات مرفقة</h2> -->
                <label for="" class='thumpnailButton1' id="uploadbutton">إختر ملف<i
                            class="fa fa-spin fa-spinner hidden"
                            id="multipleLoader"></i></label>

            </div>
            <div class="col-md-12">
                <div class="img_addqw">
                    <ul id="fileList" class="dropzone">

                    </ul>
                </div>
            </div>
            <div class="btn_ok">
                <button type="submit">إرسال رد <span class="fa fa-spin fa-spinner hidden" id="formLoader"></span>
                </button>
            </div>


            <div class="text_idks">
                <ul>
                    @foreach($tibs as $tib)
                        <li><i class="icon-error" aria-hidden="true"></i>{{$tib->value}}</li>
                    @endforeach
                </ul>
            </div>

        </form>


        <form action="/file-upload" class="dropzone aaaaa " style='display:none'>
            <div class="fallback">
                <input name="file" id='uploadInput' type="file" multiple/>
            </div>
        </form>


    </div>

@endif


<script>
    $(function () {
        var isClick = false;
        Validator['form_validate_callback'] = function (elm) {
            if (!isClick && ajaxS == ajaxR) {
                $('#formLoader').removeClass('hidden');
                $.ajax({
                    url: '/sendMessage',
                    dataType: 'json',
                    method: 'post',
                    data: elm.serialize()
                }).done(function (data) {
                    if (data.status) {
                        $('#messageSection').prepend(data.view);
                        myNoty('تم ارسال الرسالة', 'success');
                        $('#fileList').empty();
                        $('#content').val('');
                        $("html, body").animate({scrollTop: $('.massagesq').eq(-2).offset().top}, 1000);
                    } else {
                        myNoty(data.msg, 'danger')

                    }
                    $('#formLoader').addClass('hidden');
                }).error(function () {
                    myNoty('حصل خطأ غير متوقع الرجاء المحاولة مرة أخرى');
                    $('#formLoader').addClass('hidden');

                });
            } else {
                myNoty('الرجاء الإنتظار')
            }
        };
        Dropzone.autoDiscover = false;

        var ajaxS = 0;
        var ajaxR = 0;
        var drobzoneFile = new Dropzone(".aaaaa", {
            url: "/upload",
            parallelUploads: 1,
            addRemoveLinks: true,
            previewsContainer: '.dropzone',
            clickable: '#uploadbutton',
            paramName: "file", // The name that will be used to transfer the file
            acceptedFiles: '{{getFileType('message')}}',
            maxFilesize: 10, // MB
            dictFallbackMessage: 'هذا المتصفح لا يدعم السحب والافلات',
            dictFallbackText: 'اسحب الملفات هنا',
            dictInvalidFileType: 'هذا الملف غير مدعوم',
            dictFileTooBig: 'حجم الملف أكبر من الحد الأقصى للملفات',
            dictCancelUpload: '',
//             dictCancelUploadConfirmation:'هل انت متأكد من الغاء الرفع',
            dictRemoveFile: '',
            dictMaxFilesExceeded: 'لقد تجاوزت الحد الأقصى للملفات المرفوعة',
            accept: function (file, done) {
                done();
            },
            init: function () {

                //Open first, before setting the request headers.
                this.on("addedfile", function (file) {
                   
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
                    ajaxR++;
                    if (data.status) {
                        file._titleBox = Dropzone.createElement("<input value='" + data.file_id + "' type='hidden' class='hiddenInput' name='files[]' >");
                        file.previewElement.appendChild(file._titleBox);

                    } else {
                        nofication_error(data.msg);
                    }
                });
                this.on("removedfile", function (file) {

                });
                this.on("dictRemoveFile", function (file) {

                });
                this.on("sending", function (file, xhr, data) {
                    ajaxS++;
//                    $('#multipleLoader').removeClass('hidden');
                    data.append("_token", "<?=csrf_token()?>");
                });
            },

        });


    })
</script>