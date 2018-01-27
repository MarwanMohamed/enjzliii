<?php global $setting; ?>
@extends('front.__template')
@section('title',$project->title)
@section('content')
    <script type='text/javascript' language='JavaScript'>
        function refer() {
            if (document.referrer != "") {
                var referringURL = document.referrer;
                alert(referringURL);
            }
            alert('here ');
        }
    </script>


    <section class="s_404">
        <div class="container">
            <div class="heade_divprof single_pr">
                <h2>{{$project->title}}</h2>
                <ul>
                    <li><span class="{{projectcolor($project,$setting)}}"><i
                                    class="{{projecticon($project, $setting)}}"></i></span>{{projectStatus($project,$setting)}}
                    </li>
                    <li><span class="fsas2"><i
                                    class="icon-time"></i></span>{{date('Y-m-d',strtotime($project->created_at))}}</li>
                    <li><span class="fsas3"><i
                                    class="icon-folder2"></i></span>{{$project->specialization?$project->specialization->name:''}}
                    </li>
                </ul>
            </div>
        </div>
    </section>
    <section class="s_profile">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="alert alert-danger exMessage" style="display: none;">بامكانك التعديل مرة واحده فقط للمستخدم</div>
                    <div class="all_item_profsingle">
                        <div class="heade_div2">
                            <h2>تفاصيل المشروع </h2>
                            <div class="left_item_headersa somaasqwe">
                                @if((session('user')['id']==$project->projectOwner_id||session('user')['id']==$project->VIPUser)&& session('user')['id']&&$project->isOpen()&&(!$project->isBlock)&&(!$project->isPrivate))
                                    <a href="/freelancer/{{$project->id}}">دعوة المنجزين</a>
                                    @if($editablePrice)
                                    <a class="Confirm" onclick="showMessage()" style="cursor: pointer;">تعديل الميزانية</a>
                                    @endif
                                @endif
                        <section class="get_some_error2">
                                <div class="bg_get_some_error2"></div>
                                <div class="get_some_error_item2">
                                    <div class="heade_div2">
                                        <h2>تعديل الميزانية</h2>
                                        <button class="close_get_some2"><i class="icon-delete"></i></button>
                                    </div>
                                   <form id="handleAddProject" action="{{route('editable.price', $project->id)}}" method="post">
                                    {{csrf_field()}}
                                        <div class="item_protfolio">
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12">
                                                    <h2>ميزانية المشروع</h2>
                                                        <select name="editable">
                                                                @foreach($projectbudget as $value)
                                                                    <option value="{{$value->id}}">{{'$'.$value->min.'-$'.$value->max}}</option>
                                                                @endforeach
                                                        </select>
                                                </div>
                                            </div>
                                               
                                               
                                            <div class="row">
                                                
                                                <div class="col-md-12">
                                                    <div class="btn_ok">
                                                        <button>تعديل<i class='fa fa-spin fa-spinner hidden' id='formLoader'></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </section>
                                @if(session('user')['id']==$project->user_id)
                                    <div class="shear_list">
                                        <ul>
                                            <li>
                                                <button class="orgnageq" id="fofaretP"><i class="icon-star"></i>
                                                    للمفضلة<span class="fa fa-spin fa-spinner hidden"
                                                                 id="favoriteLoader"></span></button>
                                            </li>
                                            <li>
                                                <button class="blueeq" id="tabelg"><i class="icon-flag"></i>إبلاغ
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="item_h2ss">
                            <div class="like_tabel">
                                <div class="tr-th-tabel">
                                    <h4 class="tr">بطاقة المشروع</h4>
                                    <div class="content_td">
                                        <div class="card_ppl">
                                            @if($project->isVIP)
                                                <a href="/singleUser/{{$project->VIPOwner->getId()}}">
                                                    <img class="img_cardppl"
                                                         src="{{($project->VIPOwner->avatar())}}"
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
{{--                                                <p>{{ getFormatDaysFromDate($projectEnd->created_at)}}</p>--}}
                                                <p>{{$projectEnd->created_at->toDateString()}}</p>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="tr-th-tabel">
                                        <h4 class="tr">الميزانية</h4>
                                        <div class="content_td">
                                            <div class="cont_tab">
                                                <i class="icon-dollarsymbol"></i>
                                                <p>{{$project->budget?$project->budget->fBudget():''}}</p>
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
                        @if($s!= 3 && $s != 6 && projectStatus($project,$setting) != 'محظور' && projectStatus($project,$setting) != 'بإنتظار الموافقة' && projectStatus($project,$setting) != 'ملغي' && projectStatus($project,$setting) != 'مغلق')
                            <div class="left_side_step">
                                <ul>
                                    <ol class="list-inline text-center step-indicator">
                                        <li class="complete">
                                            <div class="step"><span class="icon-checked"></span></div>
                                            <div class="caption ">تلقي المنجزين</div>
                                        </li>
                                        <li class="{{($project->status<3)?'':'complete'}} ">
                                            <div class="step">{!! ($project->status < 3)?'2':'<span class="icon-checked"></span>' !!}</div>
                                            <div class="caption ">تنفيذ المشروع</div>
                                        </li>
                                        <li class="{{($project->status!=6)?'':'complete'}}  {{($project->status>=3&&$project->status!=6)?'':''}}">
                                            <div class="step">{!! ($project->status != 6)?'3':'<span class="icon-checked"></span>' !!}</div>
                                            <div class="caption">تسليم المشروع</div>
                                        </li>
                                    </ol>
                                </ul>
                            </div>

                        @else
                            <div class="item_h2ssp">
                                @if(projectStatus($project,$setting) == 'بإنتظار الموافقة')
                                    <h2 style="text-align: center;">الشروع قيد الدراسة</h2>
                                @elseif(projectStatus($project,$setting) == 'ملغي' ))
                                <h2 style="text-align: center;">تم الغاء المشروع<!--ا2--></h2>
                                @elseif($s==6 ||  projectStatus($project,$setting) == 'محظور')
                                    <h2 style="text-align: center;">تم حظر المشروع من قبل الادارة</h2>
                                @elseif($s==3 || projectStatus($project,$setting) == 'مغلق')
                                    <h2 style="text-align: center;">تم اغلاق المشروع</h2>
                                @endif
                            </div>
                        @endif
                    </div>



                    @if(!$isOwner)
                        <div class="all_item_profsingle">
                            <div id="addBidContent">
                                @if($userBid)
                                    @include('project.userBid')
                                @else
                                    <?php $ch = checkCloseBid($project, $setting); ?>

                                    @if($ch!=8)
                                        <div class="heade_div2">
                                            <h2>العروض مغلقة</h2>
                                        </div>
                                        @if($ch===2)
                                            <div class="item_h2ssp">
                                                <h2>انتهى التقديم لهذا المشروع</h2>
                                            </div>
                                        @elseif($ch==3)
                                            <div class="item_h2ssp">
                                                <h2>تم اغلاق هذا المشروع لتجاوزه الحد الأقصى لعدد الأيام</h2>
                                            </div>
                                        @elseif($ch==4)
                                            <div class="item_h2ssp">
                                                <h2>أنت غير مسجل دخولك لدينا في الوقت لحالي، لتقديم عرضك يرجى <a
                                                            href="/register">التسجيل</a> أو <a href="/login">تسجيل
                                                        الدخول</a></h2>
                                            </div>
                                        @elseif($ch==5)
                                            <div class="item_h2ssp">
                                                <h2>تم حظرك من قبل الإدارة .</h2>
                                            </div>
                                        @elseif($ch==6)
                                            <div class="item_h2ssp">
                                                <h2>هذا المشروع محظور من قبل الإدارة .</h2>
                                            </div>
                                        @elseif($ch==7)
                                            <div class="item_h2ssp">
                                                <h2>لا يمكنك تقديم عروض على المشاريع لان حسابك VIP</h2>
                                            </div>
                                        @endif
                                    @else
                                        @include('project.addBid')
                                    @endif
                                @endif
                               
                            </div>

                        </div>
                    @endif
                    <div id="bidsContent">
                        @if($isOwner)
                            @include('project.bidOwner')
                        @else
                            @include('project.bids')
                        @endif

                    </div>
                </div>
                <div class="col-md-4">
                    <div class="all_item_prof hid_mobsq">
                        <div class="heade_div2">
                            <h2>تقدّم المشروع</h2>
                        </div>
                        <?php $s = checkCloseBid($project, $setting, 1); ?>
                        @if($s!= 3  && $s != 6 && projectStatus($project,$setting) != 'محظور' && projectStatus($project,$setting) != 'بإنتظار الموافقة'  && projectStatus($project,$setting) != 'ملغي' && projectStatus($project,$setting) != 'مغلق')
                            <div class="left_side_step">
                                <ul>
                                    <ol class="list-inline text-center step-indicator">
                                        <li class="complete">
                                            <div class="step"><span class="icon-checked"></span></div>
                                            <div class="caption ">تلقي المنجزين</div>
                                        </li>
                                    <!--                                 <li class="{{($project->status<3)?'incomplete active':'complete'}} "> -->
                                        <li class="{{($project->status<3)?'':'complete'}} ">
                                            <div class="step">{!! ($project->status < 3)?'2':'<span class="icon-checked"></span>' !!}</div>
                                            <div class="caption ">تنفيذ المشروع</div>
                                        </li>
                                        <li class="{{($project->status!=6)?'':'complete'}}  {{($project->status>=3&&$project->status!=6)?'':''}}">
                                            <div class="step">{!! ($project->status != 6)?'3':'<span class="icon-checked"></span>' !!}</div>
                                            <div class="caption">تسليم المشروع</div>
                                        </li>
                                    </ol>
                                </ul>
                            </div>

                        @else
                            <div class="item_h2ssp">
                                @if(projectStatus($project,$setting) == 'بإنتظار الموافقة')
                                    <h2 style="text-align: center;">المشروع قيد الدراسة</h2>
                                @elseif($s==6 || projectStatus($project,$setting) == 'محظور')
                                    <h2 style="text-align: center;">تم حظر المشروع</h2>
                                @elseif(projectStatus($project,$setting) == 'ملغي')
                                    <h2 style="text-align: center;">تم الغاء المشروع<!--ا2--></h2>
                                @elseif($s == 3 || projectStatus($project,$setting) == 'مغلق')
                                    <h2 style="text-align: center;">تم اغلاق المشروع</h2>

                                @endif

                            </div>                    @endif
                    </div>
                    @if($project->status==6 || $project->status==3)
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
                                        <h2>{{$freelancerU->fname.' '.$freelancerU->lname}}</h2></a>
                                    <ul>

                                        <h3><span><i id="{{(isOnline($freelancerU->lastLogin))?'active':''}}"
                                                     class="fa fa-circle"
                                                     aria-hidden="true"></i></span> {{isOnline($freelancerU->lastLogin)?'متصل':'غير متصل'}}
                                        </h3>
                                        <h3>
                                            <span><i class="icon-folder1"></i></span> {{$freelancerU->specialization->name}}
                                        </h3>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    @endif
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
                                    <button data-clipboard-text="{{url('/').'/project/'.$project->id}}" id="copyUrl">
                                        نسخ
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
                    <input type="hidden" name="type" value="1">
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

@endsection

@section('script')

    <link rel="stylesheet" href="https://rawgit.com/enyo/dropzone/master/dist/dropzone.css">
    <script src="/front/js/clipboard/clipboard.min.js"></script>

    <script>

        function showMessage() {
            $('.exMessage').show();
                setTimeout(function(){ 
                    $('.get_some_error2').show();
                }, 3000);

        }

        var fofaret1 = false;
        $('#fofaretP').click(function () {
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
                    if (data.status)
                        nofication_good(data.msg, 2500);
                    else
                        nofication_error(data.msg, 2500);

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

            function getPortfolios(page=1) {
                $.ajax({
                    url: '/getBidsProject?id=<?= $project->id ?>&bidsOrder=' + bidsOrder + '&page=' + page,
                    dataType: 'json',
                }).done(function (data) {
                    $('#bidsContent').html(data.view);
                    location.hash = page;
                    $("body").animate({scrollTop: $('.item_h2ssps').offset().top}, 1000);
                }).fail(function () {
                    nofication_error('حصل خطأ');
                });
            }

        editClick = false;
        $('body').on('click', '#editBid', function (e) {
            e.preventDefault();

            if (!editClick) {
                editClick = true;
                url = $(this).data('href');
                $('#editLoader').removeClass('hidden');
                $.ajax({
                    url: url,
                    dataType: 'json',
                }).done(function (data) {
                    if (data.status) {
                        $('#addBidContent').html(data.view);
                    } else {
                        nofication_error(data.msg);
                    }
                    editClick = false;

                    $('#editLoader').addClass('hidden');

                }).fail(function () {
                    $('#editLoader').addClass('hidden');

                    nofication_error('حصل خطأ');
                });
            }
        })


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
            $('body').on('keyup', '#cost', function () {
                var siteRate = "<?= $setting['site_rate'] ?>";
                var dues = parseInt($(this).val()) * (1 - siteRate);
                dues = parseFloat(Math.round(dues * 100) / 100).toFixed(2);

                $('#dues').val(dues);
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
                    if (files != uploads) {
                        nofcation_error('الرجاء انتظار رفع الملفات');
                        return;
                    }
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
                            nofication_error('حصل خطأ');
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