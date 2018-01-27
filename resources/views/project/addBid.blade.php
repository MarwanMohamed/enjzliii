<style>
    .specialization1{
        position: relative;
        bottom: 5px;
    }
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
</style>
<?php global $setting?>
<div class="item_h2sspq">
    <div class="row">
        <form action="/addBids" id="addBids">
            <input type="hidden" value="{{(isset($bidEdit))?$bidEdit->id:0}}" name="id">
            <div class="col-md-4">
                <div class="plus_input">
                    <h2>مدة التسليم<span>*</span></h2>
                    <span class="input-group-btn mins">
                          <button type="button" class="btn btn-default btn-number minus" data-type="project-day">
                              <span class="glyphicon glyphicon-minus"></span>
                          </button>
                      </span>
                    <input type="number" required id="deliveryDuration" name="deliveryDuration"
                           value="{{isset($bidEdit)?$bidEdit->deliveryDuration:''}}" class="input-number project-day"
                           min="1" max="9999">
                    <span class="input-group-btn plusq">
                          <button type="button" class="btn btn-default btn-number plus" data-type="project-day">
                              <span class="glyphicon glyphicon-plus"></span>
                          </button>
                      </span>
                    <p class="item_off">أيام</p>
                </div>
            </div>
            <input type="hidden" name="project_id" value="{{(isset($bidEdit))?$bidEdit->project_id:$project->id}}">
            <div class="col-md-4">
                <div class="plus_input">
                    <h2>قيمة العرض<span>*</span></h2>
                    <span class="input-group-btn mins">
                          <button type="button" class="btn btn-default btn-number minus" data-type="project-price">
                              <span class="glyphicon glyphicon-minus"></span>
                          </button>
                      </span>
                    <input type="number" required name="cost" class="input-number project-price cost"
                           value="{{(isset($bidEdit))?$bidEdit->cost:''}}" id="cost" min="1" max="999999">
                    <span class="input-group-btn plusq" >
                        <button type="button" class="btn btn-default btn-number plus" data-type="project-price">
                            <span class="glyphicon glyphicon-plus"></span>
                        </button>
                    </span>
                    <p class="item_off">$</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="plus_input">
                    <h2>مستحقات نهائية بعد خصم<span>(عمولة إنجزلي)</span></h2>
                    <input type="text" class="input-number" name="dues" id="dues"
                           value="{{isset($bidEdit)?$bidEdit->dues:''}}" disabled="disabled">
                    <p class="item_offs">$</p>
                </div>
            </div>
            <div class="col-md-12">
                <div class="plus_input">
                    <h2>نص العرض<span>*</span></h2>
                    <textarea rows="6" required minlength="25" name="letter">{{isset($bidEdit)?$bidEdit->letter:''}}</textarea>
                </div>
            </div>
            <div class="col-md-5">
                <div class="plus_input_drag">
                    <h2>ملفات مرفقة</h2>
                    <div class=" drop" id="multipleFile">
                        <div class="dz-default dz-message" data-dz-message="jl">
                            <div class="multipleButton">
                                <label for="" id="">إختر ملف<i class="fa fa-spin fa-spinner hidden" id="multipleLoader1"></i></label>
                                <h3>سحب وإفلات الملفات هنا</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-md-offset-1">
                <div class="list_no">
                    <ul>
                        @foreach($bidTibs as $bidTib)
                            <li><i class="icon-error" aria-hidden="true"></i>{{$bidTib->value}}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-md-12">
                <div class="img_addqw">
                    <ul id="fileList" class="dropzone">
                        @if(isset($bidEdit))
                            <?php
                            $files = ($bidEdit->file);
                            foreach ($files as $file){
                            $isImage = strpos($file, 'image');
                            $url = ($isImage !== false) ? '/image/200x200/' . $file->name : '/front/images/file.png';
                            ?>
                            <li>
                                <div class='img_first_add'>
                                    <img src='{{$url}}'>
                                    <input type='hidden' name='files[]' value='{{$file->id}}'>
                                    <div class='bg_this_img'>
                                        <a href='#' class='deleteFile'><i class='icon-delete'></i></a>
                                    </div>
                                </div>
                            </li>
                            <?php }?>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-md-12">
                <div class="btn_ok">
                    <button><span class="fa fa-spin fa-spinner hidden" id="formLoader"></span>اضف عرضك</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    var files = 0;
    var uploads = 0;
    $(function () {
        Dropzone.autoDiscover = false;
        var drobzoneFile = new Dropzone("div#multipleFile", {
            url: "/upload",
            parallelUploads: 1,
            addRemoveLinks: true,
            acceptedFiles: '{{getFileType('proposal')}}',
            paramName: "file", // The name that will be used to transfer the file
            maxFilesize: 10, // MB
            dictFallbackMessage: 'هذا المتصفح لا يدعم السحب والافلات',
            dictFallbackText: 'اسحب الملفات هنا',
            dictInvalidFileType: 'هذا الملف غير مدعوم',
            dictFileTooBig: 'حجم الملف أكبر من الحد الأقصى للملفات',
            dictCancelUpload: '',
            dictRemoveFile: '',
            dictMaxFilesExceeded: 'لقد تجاوزت الحد الأقصى للملفات المرفوعة',
            previewsContainer: '.dropzone',
            accept: function (file, done) {
                done();
            },
            init: function () {
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
                //Open first, before setting the request headers.
                this.on("success", function (file, data) {
                    files++;
                    if (files == uploads) {
                        $('#multipleLoader').addClass('hidden');
                    }
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
                    $('#multipleLoader').removeClass('hidden');
                    data.append("_token", "<?=csrf_token()?>");
                    uploads++;
                });
            },
        });
    })
</script>