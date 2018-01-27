<?php global $setting; ?>

@extends('front.__template')
@section('title','نقاش المشروع')

@section('content')
    <style>
        .starWidth {
            width: 14px;
            height: 23px;
        }

        #myDrop label, #multipleFile label {
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

        .dz-preview {
            display: none;
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

        .dropzone .dz-preview .dz-error-message {
            top: 113px !important;
            left: -5px !important;
        }

        .dropzone .dz-preview.dz-image-preview {
            width: 130px !important;
            height: 130px !important;
        }

        .dz-preview .dz-image {
            background: #ddd !important;
        }

        .dz-preview .dz-image img {
            background: #fff;
            margin: 15px 5px 0px 15px;
            width: 100px !important;
            height: 100px !important;
            border-radius: 10px;
            padding: 10px;
            margin: 15px 5px 0px 15px;
        }

        .dz-preview .dz-image img:first-of-type {
            margin: 15px 15px 0px 15px;
        }
        .left_side_items ul li {
            background:none;
            padding:0;
            display: block;
        }
    </style>
    <section class="s_404">
        <div class="container">
            <div class="heade_divprof single_pr">
                <h2>{{$project->title}}</h2>
                <ul>
                    <li><span class="{{projectcolor($project,$setting)}}"><i
                                    class="{{projecticon($project,$setting)}}"></i></span>{{projectStatus($project,$setting)}}
                    </li>
                    <li><span class="fsas2"><i
                                    class="icon-time"></i></span>{{date('Y-m-d',strtotime($project->created_at))}}</li>
                    <li><span class="fsas3"><i class="icon-folder2"></i></span>{{$project->specialization->name}}</li>
                </ul>
            </div>
        </div>
    </section>
    <section class="s_profile">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="all_item_profsingle">
                        <div class="heade_div2">
                            <h2>تفاصيل المشروع</h2>
                            @if($project->status==3&&(!$project->isBlock))
                                @if(session('user')['id']==$project->projectOwner_id||session('user')['id']==$project->VIPUser)
                                    <div class="left_item_headersa somaasqwe">

                                        @if($project->freelancer[0]->freealancerFinish || !isCloseProject($project->id))
                                            <a href='javascript:;' data-info="{{getProjectCost($project->id)}}"
                                               data-href="/finishProject/{{$project->id}}"
                                               class="confirmReceiveProject"> إستلام
                                                المشروع</a>
                                        @endif
                                        @if(!isCloseProject($project->id))
                                            <a href="/cancelFreelancer/{{$project->id}}" id='cancelFreelancer'
                                               data-id='{{$project->id}}'>الغاء المشروع</a>
                                        @endif
                                    </div>

                                @else
                                    <div class="left_item_headersa somaasqwe">
                                        @if(!$project->freelancer[0]->freealancerFinish)
                                            <a href='javascript:;' data-info="{{getProjectCost($project->id)}}"
                                               data-href="/orderFinishProject/{{$project->id}}"
                                               class="confirmProjectFinish">انهاء المشروع</a>
                                               
                                        @elseif($project->status==3)
                                            <label href="javascript:;" class="label-mb">تم تقديم طلب انهاء
                                                المشروع</label>
                                        @endif
                                    </div>
                                @endif
                            @endif
                        </div>
                        <div class="item_h2ss">
                            <div class="like_tabel">
                                <div class="tr-th-tabel">
                                    <h4 class="tr">بطاقة المشروع</h4>
                                    <div class="content_td">
                                        <div class="card_ppl">
                                            @if($project->isVIP)
                                                <a href="/singleUser/{{$project->VIPOwner->getId()}}">
                                                    <img class="img_cardppl" src="{{($project->VIPOwner->avatar())}}"
                                                         title="test">
                                                    @else
                                                        <a href="/singleUser/{{$project->owner->getId()}}">
                                                            <img class="img_cardppl"
                                                                 src="{{($project->owner->avatar())}}"
                                                                 title="test">
                                                            @endif
                                                            @if($project->isVIP)
                                                                <h2>{{$project->VIPOwner->fullname()}}</h2>
                                                            @else
                                                                <h2>{{$project->owner->fullname()}}</h2>
                                                            @endif
                                                            <h3>
                                                                @if($project->isVIP)
                                                                    <span><i class="icon-folder2"></i></span>{{$project->VIPOwner->specialization?$project->VIPOwner->specialization->name:''}}
                                                                @else
                                                                    <span><i class="icon-folder2"></i></span>{{$project->owner->specialization?$project->owner->specialization->name:''}}
                                                                @endif
                                                            </h3>

                                                            <h3>
                                                                @if($project->isVIP)
                                                                    <span><i class="icon-location"></i></span>{{$project->VIPOwner->country->name}}
                                                                @else
                                                                    <span><i class="icon-location"></i></span>{{$project->owner->country->name}}
                                                                @endif
                                                            </h3>
                                                        </a>
                                        </div>

                                    </div>
                                </div>

                                <div class="tr-th-tabel">
                                    <h4 class="tr">مدة التنفيذ</h4>
                                    <div class="content_td">
                                        <div class="cont_tab">
                                            <i class="icon-clock"></i>
                                            <p>
                                                @if($project->deliveryDuration == 1)
                                                    يوم
                                                @elseif($project->deliveryDuration == 2)

                                                    يومين
                                                @elseif($project->deliveryDuration >=3 && $project->deliveryDuration<= 10 )
                                                    {{$project->deliveryDuration}}
                                                    ايام
                                                @else
                                                    {{$project->deliveryDuration}}
                                                    يوماً
                                                @endif

                                            </p>
                                        </div>
                                    </div>
                                </div>
                                @if($project->status == 6)
                                    <div class="tr-th-tabel">
                                        <h4 class="tr">المبلغ</h4>
                                        <div class="content_td">
                                            <div class="cont_tab">
                                                <i class="icon-dollarsymbol"></i>
                                                <p> {{$projectEnd->cost}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tr-th-tabel">
                                        <h4 class="tr">الإنتهاء</h4>
                                        <div class="content_td">
                                            <div class="cont_tab">
                                                <i class="icon-clock"></i>
                                                <p>{{ getProjectEndedDate($projectEnd->created_at,$projectEnd->deliveryDuration)}}</p>


                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="tr-th-tabel">
                                        <h4 class="tr">الميزانية</h4>
                                        <div class="content_td">
                                            <div class="cont_tab">
                                                <i class="icon-dollarsymbol"></i>
                                                <p>{{$project->budget->fBudget()}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tr-th-tabel">
                                        <h4 class="tr">متوسط العروض</h4>
                                        <div class="content_td">
                                            <div class="cont_tab">
                                                <i class="icon-coins"></i>
                                                <p>{{avarage($project->bids)}}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="tr-th-tabel">
                                    <h4 class="tr">عدد العروض</h4>
                                    <div class="content_td">
                                        <div class="cont_tab">
                                            <i class="icon-folder2"></i>
                                            <p>{{$project->bids->count()}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if(session('user')['id']==$project->user_id)
                                <div class="shear_list">
                                    <ul>
                                        <li>
                                            <button class="orgnageq" id="fofaretP"><i class="icon-star"></i>
                                                للمفضلة<span class="fa fa-spin fa-spinner hidden"
                                                             id="favoriteLoader"></span></button>
                                        </li>
                                        <li>
                                            <button class="blueeq" id="tabelg"><i class="icon-flag"></i>إبلاغ</button>
                                        </li>
                                    </ul>
                                </div>
                            @endif
                        </div>

                    </div>
                    <div class="all_item_profsingle">
                        <div class="heade_div2">
                            <h2>وصف المشروع </h2>
                        </div>
                        <div class="item_h2ss">

                            <?php $files = $project->file ?>

                            <div class="first_item_h2s new-size-r">
                                <?php
                                $lines = explode(PHP_EOL, $project->description);
                                foreach ($lines as $line) {
                                ?>
                                <p>{{$line}}</p>
                                <?php } ?>
                            </div>
                            <div class='project-attachment'>
                                @include('project.attachment')
                            </div>

                        </div>
                    </div>
                    @if($evaluate && ($project->status==6 || $project->status==4))
                        <div class="all_item_profsingle">
                            <div class="heade_div2">
                                <h2>تقييم المشروع</h2>
                            </div>
                            <div class="divt_rate">
                                <div class="first_rate">
                                    <h2>الإحترافية بالتعامل</h2>
                                    <ul>
                                        @for($i=0 ;$i<5;$i++)
                                            <li class="{{($i<$evaluate->ProfessionalAtWork)?'active':''}}"><i
                                                        class="icon-star"></i></li>
                                        @endfor
                                        <li>{{$evaluate->ProfessionalAtWork}}</li>
                                    </ul>
                                </div>
                                <div class="first_rate">
                                    <h2>التواصل والمتابعة</h2>
                                    <ul>
                                        @for($i=0 ;$i<5;$i++)
                                            <li class="{{($i<$evaluate->CommunicationAndMonitoring)?'active':''}}">
                                                <i
                                                        class="icon-star"></i></li>
                                        @endfor
                                        <li>{{$evaluate->CommunicationAndMonitoring}}</li>
                                    </ul>
                                </div>
                                <div class="first_rate">
                                    <h2>جودة العمل المسلّم </h2>
                                    <ul>
                                        @for($i=0 ;$i<5;$i++)
                                            <li class="{{($i<$evaluate->quality)?'active':''}}"><i
                                                        class="icon-star"></i></li>
                                        @endfor
                                        <li>{{$evaluate->quality}}</li>
                                    </ul>
                                </div>
                                <div class="first_rate">
                                    <h2>الخبرة بمجال المشروع </h2>
                                    <ul>
                                        @for($i=0 ;$i<5;$i++)
                                            <li class="{{($i<$evaluate->experience)?'active':''}}"><i
                                                        class="icon-star"></i></li>
                                        @endfor
                                        <li>{{$evaluate->experience}}</li>
                                    </ul>
                                </div>
                                <div class="first_rate">
                                    <h2>التعامل معه مرّة أخرى </h2>
                                    <ul>
                                        @for($i=0 ;$i<5;$i++)
                                            <li class="{{($i<$evaluate->workAgain)?'active':''}}"><i
                                                        class="icon-star"></i></li>
                                        @endfor
                                        <li>{{$evaluate ->workAgain}}</li>
                                    </ul>
                                </div>
                            </div>
                            <h3 class="answ_ppl">{{$evaluate->note}}</h3>

                        </div>
                    @endif

                    <div class="all_item_prof hid_mobsq2">
                        <div class="heade_div2">
                            <h2>تقدّم المشروع</h2>
                        </div>
                        <?php $s = checkCloseBid($project, $setting, 1); ?>
                        @if($s!= 3 && $s != 6 && projectStatus($project,$setting) != 'ملغي'  && projectStatus($project,$setting) != 'بإنتظار الموافقة' && projectStatus($project,$setting) != 'محظور' && projectStatus($project,$setting) != 'مغلق')
                            <div class="left_side_step">
                                <ul>
                                    <ol class="list-inline text-center step-indicator">
                                        <li class="complete">
                                            <div class="step"><span class="icon-checked"></span></div>
                                            <div class="caption">تلقي المنجزين</div>
                                        </li>
                                        <li class="{{($project->status<3)?'':'complete'}} ">
                                            <div class="step">{!! ($project->status < 3)?'2':'<span class="icon-checked"></span>' !!}</div>
                                            <div class="caption ">تنفيذ المشروع</div>
                                        </li>
                                        <li class="{{($project->status!=6)?'':'complete'}}  {{($project->status>=3&&$project->status!=6)?'':''}}">
                                            <div class="step">{!! ($project->status != 6)?'3':'<span class="icon-checked"></span>' !!}</div>
                                            <div class="caption ">تسليم المشروع</div>
                                        </li>
                                    </ol>
                                </ul>
                            </div>
                        @elseif(projectStatus($project,$setting) == 'بإنتظار الموافقة')
                            <h2 style="text-align: center;">المشروع قيد الدراسة</h2>
                        @elseif($s==6 ||  projectStatus($project,$setting) == 'محظور')
                            <div class="item_h2ssp"><h2 style="text-align: center;">تم حظر المشروع من قبل الادارة</h2>
                            </div>
                        @elseif(projectStatus($project,$setting) == 'ملغي')
                            <div class="item_h2ssp"><h2 style="text-align: center;">تم الغاء المشروع<!--ا2--></h2></div>
                        @elseif($s == 3 || projectStatus($project,$setting) == 'مغلق')
                            <h2 style="text-align: center;">تم اغلاق المشروع</h2>

                        @endif
                    </div>

                  

                    <div class="all_item_profsingle">
                        <div class="heade_div2">
                            <h2>نقاش المشروع</h2>
                        </div>
                        <div class="item_h2ssps resultForm">
                            @include('project.singleDescussen')

                        </div>
                    </div>
                    @if($project->status==3 &&(!$project->isBlock))
                        <div class="all_item_profsingle">
                            <div class="heade_div2">
                                <h2>أضف ردك</h2>
                            </div>
                            <form action="/addDescussion" id="addDescussion" class="ajaxForm" method="post">
                                <input type="hidden" name="project_id" value="{{$project->id}}">
                                <div class="item_h2sspq">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="plus_input">
                                                <h2>أضف ردك<span>*</span></h2>
                                                <textarea rows="6" required name="content"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">

                                            <label for="" class='thumpnailButton1' id="uploadbutton">إختر ملف<i
                                                        class="fa fa-spin fa-spinner hidden"
                                                        id="multipleLoader"></i></label>
                                        </div>
                                        <!--                                 <div class="col-md-12 hidden">
                                                                            <div class="plus_input_drag">
                                                                                <h2>ملفات مرفقة</h2>
                                                                                <div class=" drop" id="multipleFile">
                                                                                    <div class="dz-default dz-message" data-dz-message="jl">
                                                                                        <div class="multipleButton">
                                                                                            <label for="" id="">إختر ملف<i
                                                                                                    class="fa fa-spin fa-spinner hidden"
                                                                                                    id="multipleLoader"></i></label>
                                                                                            <h3>سحب وإفلات الملفات هنا</h3>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div> -->
                                        {{csrf_field()}}
                                        <div class="col-md-12">
                                            <div class="img_addqw">
                                                <ul id="fileList" class='dropzone'>

                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="btn_ok">
                                                <button> أضف ردك <i class="fa fa-spinner fa-spin  "
                                                                    style="display: none;" id="loader"></i></button>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </form>


                            <form action="/file-upload" class="dropzone aaaaa " style='display:none'>
                                <div class="fallback">
                                    <input name="file" id='uploadInput' type="file" multiple/>
                                </div>
                            </form>

                        </div>
                    @elseif($project->isBlock)
                        <div class="all_item_profsingle">
                            <div class="heade_div2">
                                <h4 style="width: 100%;text-align: center;padding: 20px;color:red">تم حظر المشروع, لمزيد
                                    من المعلومات تواصل مع الإدارة</h4>
                            </div>
                        </div>
                    @elseif($project->status==6)
                        <div class="all_item_profsingle">
                            <div class="heade_div2">
                                <h4 style="width: 100%;text-align: center;padding: 20px;color:red">تم انهاء المشروع</h4>
                            </div>
                        </div>
                    @else
                        <div class="all_item_profsingle">
                            <div class="heade_div2">
                                <h4 style="width: 100%;text-align: center;padding: 20px;color:red">تم الغاء المشروع من
                                    قبل الإدارة</h4>
                            </div>
                        </div>
                    @endif
                    @include('project.bids')
                </div>

                <div class="col-md-4">
                    <div class="all_item_prof hid_mobsq">
                        <div class="heade_div2">
                            <h2>تقدّم المشروع</h2>
                        </div>
                        <?php $s = checkCloseBid($project, $setting, 1); ?>

                        @if($s!= 3 && $s != 6 && projectStatus($project,$setting) != 'محظور' && projectStatus($project,$setting) != 'بإنتظار الموافقة' && projectStatus($project,$setting) != 'ملغي' && projectStatus($project,$setting) != 'مغلق' )
                            <div class="left_side_step">
                                <ul>
                                    <ol class="list-inline text-center step-indicator">
                                        <li class="complete">
                                            <div class="step"><span class="icon-checked"></span></div>
                                            <div class="caption hidden-xs hidden-sm">تلقي المنجزين</div>
                                        </li>
                                        <li class="{{($project->status<3)?'':'complete'}} ">
                                            <div class="step">{!! ($project->status < 3)?'2':'<span class="icon-checked"></span>' !!}</div>
                                            <div class="caption hidden-xs hidden-sm">تنفيذ المشروع</div>
                                        </li>
                                        <li class="{{($project->status!=6)?'':'complete'}}  {{($project->status>=3&&$project->status!=6)?'':''}}">
                                            <div class="step">{!! ($project->status != 6)?'3':'<span class="icon-checked"></span>' !!}</div>
                                            <div class="caption hidden-xs hidden-sm">تسليم المشروع</div>
                                        </li>
                                    </ol>
                                </ul>
                            </div>
                        @elseif(projectStatus($project,$setting) == 'بإنتظار الموافقة')
                            <h2 style="text-align: center;">المشروع قيد الدراسة</h2>
                        @elseif($s==6 || projectStatus($project,$setting) == 'محظور')
                            <div class="item_h2ssp"><h2 style="text-align: center;">تم حظر المشروع من قبل الادارة</h2>
                            </div>
                        @elseif(projectStatus($project,$setting) == 'ملغي')
                            <div class="item_h2ssp"><h2 style="text-align: center;">تم الغاء المشروع<!--ا2--></h2></div>
                        @elseif($s == 3 || projectStatus($project,$setting) == 'مغلق')
                            <h2 style="text-align: center;">تم اغلاق المشروع</h2>

                        @endif
                    </div>
                    @php
                        $freelancerU = getUserFromProject($project->id);
                    @endphp
                    <div class="all_item_prof hid_mobsq3">
                        <div class="heade_div2">
                            <h2>منجز المشروع</h2>
                        </div>
                        <div class="left_side_items">
                            <div class="img_divprof">
                                <a href="/singleUser/{{$freelancerU->id}}"><img width="100%" height="100%"
                                                                                src="{{ !empty(avatar($freelancerU->avatar,$setting))?avatar($freelancerU->avatar,$setting):$imageType}}"
                                                                                title="user"></a>
                            </div>
                            <div class="text_divprof">
                                <a href="/singleUser/{{$freelancerU->id}}">
                                    <h2>{{$freelancerU->fullname()}}</h2></a>
                                <ul>

                                    <h3><span><i id="{{(isOnline($freelancerU->lastLogin))?'active':''}}"
                                                 class="fa fa-circle"
                                                 aria-hidden="true"></i></span> {{isOnline($freelancerU->lastLogin)?'متصل':'غير متصل'}}
                                    </h3>
                                    <h3><span><i class="icon-folder1"></i></span> {{$freelancerU->specialization->name}}
                                    </h3>
                                   @php $avr = $freelancerU->stars; @endphp
                                    <ul>
                                   
                                    @for($i=0;$i<5;$i++)
                                        @if($i<$avr)
                                            <li class="active"><i class="icon-star"></i></li>
                                        @else
                                            <li><i class="icon-star"></i></li>
                                        @endif
                                    @endfor

                                    <li>{{$avr}}</li>
                                  
                                    </ul>
                                </ul>
                            </div>
                        </div>
                    </div>


                    <div class="all_item_prof hid_mobsq3">
                        <div class="heade_div2">
                            <h2>المهارات المطلوبة</h2>
                        </div>
                        <div class="left_side_items">
                            <ul>
                                @foreach($skills as $skill)
                                    <li>#{{$skill->skill->name}}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>


                    @if(!$project->isPrivate)
                        <div class="all_item_prof">
                            <div class="heade_div2">
                                <h2>شارك المشروع</h2>
                            </div>
                            <div class="left_side_itemsher">

                                <div class="input_copy">
                                    <input type="text" disabled name="" value="{{url('/').'/project/'.$project->id}}">
                                    <button data-clipboard-text="{{url('/').'/project/'.$project->id}}" id="copyUrl">نسخ
                                    </button>
                                </div>
                                <ul>
                                    <li><a href="http://www.facebook.com/sharer.php?u={{url()->full()}}" target="_blank"
                                           title="شارك على فبس بوك">فيسبوك<i class="icon-facebook"></i></a></li>
                                    <li><a href="http://twitter.com/share?url={{url()->full()}} " target="_blank"
                                           title=" شارك على تويتر">تويتر<i class="icon-twitter"></i></a></li>
                                    <li>
                                        <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{url()->full()}}"
                                           target="_blank" title="Share on LinkedIn">لينكدإن<i
                                                    class="icon-linkedin2"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>


    <section class="some_error">
        <div class="bg_some_error"></div>
        <div class="some_error_item">
            <div class="heade_div2">
                <h2>تبليغ عن محتوى</h2>
                <button class="close_some"><i class="icon-delete"></i></button>
            </div>
            <div class="item_some">
                <h2>قم بإختيار احد الأسباب التالية<span>*</span></h2>
                <form action="/report" id="report">
                    <input type="hidden" name="refer_id" value="{{$project->id}}">
                    <input type="hidden" name="type" value="2">
                    @foreach($reportReasons as $key=> $reason)
                        <div class="slideTow">
                            <input type="radio" value="{{$reason->id}}"
                                   {{(!$key)?'checked':''}} id="slideTow{{$reason->id}}" name="report"/>
                            <label for="slideTow{{$reason->id}}">{{$reason->value}}</label>
                        </div>
                    @endforeach
                    <button> إرسال <span class="fa fa-spin fa-spinner hidden" id="reportLoader"></span></button>
                </form>
            </div>
        </div>
    </section>

    <section class="cancelFreelancer">
        <div class="bg_some_error"></div>
        <div class="some_error_item">
            <div class="heade_div2">
                <h2>الغاء المشروع </h2>
                <button class="close_some"><i class="icon-delete"></i></button>
            </div>
            <div class="item_some">
                <form action="/cancelFreelancer" class='cancelFreelancerForm' method=post>
                    {{csrf_field()}}
                    <input type="hidden" name="project_id" value="{{$project->id}}">
                    <input type="hidden" name="freelancer_id" value="{{$project->freelancers[0]->freelancer_id}}">
                    <div class="form-group">
                        <label>سبب الالغاء</label>
                        <textarea rows=5 placeholder='ادخل سبب الإلغاء' name='reason' required minlength=10
                                  class='form-control reason'></textarea>
                    </div>
                    <button> إرسال <span class="fa fa-spin fa-spinner" style='display:none'
                                         id="cancelFreelancerLoader"></span></button>
                </form>
            </div>
        </div>
    </section>

  

    <style>
        label.error {
            display: block !important;
            position: absolute;
            left: 31px;
            bottom: 82px;
        }
    </style>

@endsection

@section('script')

    <link rel="stylesheet" href="https://rawgit.com/enyo/dropzone/master/dist/dropzone.css">
    <script src="/front/js/clipboard/clipboard.min.js"></script>

    <script>

        $(function () {
            $('.cancelFreelancer .close_some').click(function () {
                if (!cancelFreelancerClick)
                    $('.cancelFreelancer').hide();
                else
                    myNoty('الرجاء الانتظار');
            })

            $('.cancelFreelancerForm').validate();
            var cancelFreelancerClick = false;
            $('.cancelFreelancerForm').submit(function (e) {
                e.preventDefault();
                if (!cancelFreelancerClick) {
                    cancelFreelancerClick = true;
                    $(this).find('#cancelFreelancerLoader').show();
                    $.ajax({
                        url: '/cancelFreelancer',
                        method: 'post',
                        data: $(this).serialize()
                    }).done(function (data) {
                        if (data.status) {
                            nofication_good(data.msg);
                            location.reload();
                            $('.reason').val('');
                        } else {
                            nofication_error(data.msg);
                        }
                    }).error(function () {
                        nofication_error('حصل خطأ اثناء الإتصال بالخادم');
                    }).complete(function () {
                        cancelFreelancerClick = false;
                        $('#cancelFreelancerLoader').hide();
                        $('.cancelFreelancer').hide();
                    });
                } else {
                    myNoty('الرجاء الانتظار');
                }
            });
            $('#cancelFreelancer').click(function (e) {
                e.preventDefault();
                $('.cancelFreelancer').show();
            })


            Dropzone.autoDiscover = false;
            var files = 0;
            var ajaxUpload = 0;
            var ajaxFinish = 0;
            @if($s!=3&&$s!=6)
            // var drobzoneFile = new Dropzone("div#multipleFile", {
            var drobzoneFile = new Dropzone(".aaaaa", {
                url: "/upload",
                addRemoveLinks: true,
                previewsContainer: '#fileList',
                acceptedFiles: '{{getFileType('discussion')}}',
                paramName: "file", // The name that will be used to transfer the file
                dictFallbackMessage: 'هذا المتصفح لا يدعم السحب والافلات',
                dictFallbackText: 'اسحب الملفات هنا',
                dictInvalidFileType: 'هذا الملف غير مدعوم',
                dictFileTooBig: 'حجم الملف أكبر من الحد الأقصى للملفات',
                dictCancelUpload: '',
//     dictCancelUploadConfirmation:'هل انت متأكد من الغاء الرفع',
                dictRemoveFile: '',
                clickable: '#uploadbutton',

                dictMaxFilesExceeded: 'لقد تجاوزت الحد الأقصى للملفات المرفوعة',
                maxFilesize: 10, // MB
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
                    //Open first, before setting the request headers.

                    this.on("success", function (file, data) {
                        ajaxFinish++;
                        if (data.status) {
                            file._titleBox = Dropzone.createElement("<input value='" + data.file_id + "' type='hidden' class='hiddenInput' name='files[]' >");
                            file.previewElement.appendChild(file._titleBox);

                        } else {
                            nofication_error(data.msg);
                        }
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

            @endif
        })
    </script>




    <script>

        var fofaret1 = false;
        $('#fofaret').click(function () {
            if (!fofaret1) {
                $('#favoriteLoader').removeClass('hidden');
                fofaret1 = true;
                $.ajax({
                    url: '/fovarite',
                    data: {'refer_id': '<?= $project->id ?>', type: 2},
                    dataType: 'json'
                }).done(function (data) {
                    $('#favoriteLoader').addClass('hidden');
                    if (data.status) {
                        nofication_good(data.msg, 2500);
                    } else {
                        nofication_error(data.msg, 5000);
                    }
                    fofaret1 = false;
                })
            }
        });
        var report = false;
        $('#report').submit(function (e) {
            e.preventDefault();
            $('#reportLoader').removeClass('hidden');
            if (!report) {
                report = true;
                $.ajax({
                    url: '/report',
                    data: $(this).serialize(),
                    dataType: 'json'
                }).done(function (data) {
                    if (data.status) {
                        nofication_good(data.msg, 2500);
                        location.reload();
                    } else {
                        nofication_error(data.msg, 2500);
                    }
                    $('.some_error').hide();
                    $('#reportLoader').addClass('hidden');
                    report = false;
                })
            }
        });
        var btns = document.getElementById('copyUrl');
        var clipboard = new Clipboard(btns);
        clipboard.on('success', function (e) {
            nofication_good('تم نسخ الرابط');
        });
        clipboard.on('error', function (e) {
            nofication_error('حصل خطأ أثناء عملية النسخ');
        });
        var bidsOrder = 'desc';
        $('body').on('click', '#bidsPage .customPagination a', function (e) {
            e.preventDefault();
            var elm = $(this).html('<i class="fa fa-spinner fa-spin"></i>');
            getPortfolios(elm.attr('href').split('page=')[1], elm);
        });
        $('body').on('change', '#bidsOrder', function () {
            bidsOrder = $(this).val();
            $('#bidsOrderLoader').removeClass('hidden');
            getPortfolios(1);
        });
        if (isNaN())

            function getPortfolios(page = 1) {
                $.ajax({
                    url: '/getBidsProject?id=<?= $project->id ?>&bidsOrder=' + bidsOrder + '&page=' + page,
                    dataType: 'json',
                }).done(function (data) {
                    $('#bidsContent').html(data.view);
                    location.hash = page;
                    $("body").animate({scrollTop: $('.item_h2ssps').offset().top}, 1000);
                }).fail(function () {
                    alert('Posts could not be loaded.');
                });
            }


        //        addBid


        $(function () {
            $('#addBids').validate();
            var deliveryDuration = '';
            $('.input-number').focusin(function () {
                $(this).removeClass('error');
            });
            $('.input-number').focusout(function () {
                if (isNumber($(this).val())) {
                    $(this).removeClass('error');
                } else {
                    $(this).addClass('error');
                }

            });
            $('body').on('click', '.deleteFile', function (e) {
                e.preventDefault();
                elm = $(this).parent().parent();
                elm.parent().remove();
            });
            var addClick = false;
            $('body').on('submit', '#addBids', function (e) {
                e.preventDefault();
                if (!addClick && $(this).valid()) {
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
                            } else {

                                nofication_good(data.msg);
                                $('#addBidContent').html(data.view);
                            }
                            addClick = false;
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
            });
        });
    </script>
@endsection