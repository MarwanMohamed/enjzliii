<?php global $setting; ?>

@extends('front.__template')
@section('title','عرض العمل')

@section('content')
    <style>
        .first_item_h2s {
            padding: 20px 0px;
        }

        .item_h2ss img {
            margin-bottom: 30px;
        }

        .item_h2ss {
            padding: 30px;
        }
    </style>

    <section class="s_404">
        <div class="container">
            <div class="heade_divprof single_pr">
                <h2>{{$portfolio->title}}</h2>
                <ul>
                    <li><span class="fsas4"><i
                                    class="icon-user"></i></span>{{$portfolio->owner->fname.' '.$portfolio->owner->lname}}
                    </li>
                    <li><span class="fsas2"><i class="icon-time"></i></span>{{dateToString($portfolio->created_at)}}
                    </li>
                    <li><span class="fsas3"><i class="icon-folder2"></i></span>معرض الاعمال</li>
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
                            <h2>التفاصيل</h2>
                            @if(session('user')&&session('user')['id']==$portfolio->user_id)
                                <div class="left_item_headersa">
                                    <a href="/editPortfolio/{{$portfolio->id}}">تحرير</a>
                                </div>
                            @else
                                <div class="left_item_headersa">
                                    <a href="/addPrivateProject/{{$portfolio->user_id}}">اطلب عمل مماثل</a>
                                </div>

                            @endif

{{--                            {{dd($portfolio)}}--}}
                            @if($portfolio->url)
                                <div class="left_item_headersa">
                                    <a href="{{$portfolio->url}}" target="_blank">رابط المشروع</a>
                                </div>
                            @endif
                        </div>
                        <div class="item_h2ss">

                            <div class="first_item_h2s">
                                <?php
                                $desc = explode(PHP_EOL, $portfolio->description);
                                foreach ($desc as $value) {
                                ?>
                                <p>{{$value}}</p>
                                <?php } ?>
                            </div>

                            @if(session('user')&&session('user')['id']!=$portfolio->user_id&&(!session('user')['isVIP']))

                                <div class="shear_list">
                                    <ul>
                                        <li>
                                            <button class="greeneq likeButton" id="likeButton"><i
                                                        class="fa fa-spin fa-spinner " id="Loader"
                                                        style="display:none"></i> <i class="icon-like"></i>إعجاب
                                            </button>
                                        </li>
                                        <li>
                                            <button class="orgnageq fofaret1" id="fofaret1"><i
                                                        class="fa fa-spin fa-spinner " id="Loader"
                                                        style="display:none"></i><i class="icon-star"></i>للمفضلة
                                            </button>
                                        </li>
                                        <li>
                                            <button class="blueeq tabelg" id="tabelg"><i class="icon-flag"></i>إبلاغ
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            @endif
                            <div class="img_post">
                                <img width="100%" src="/image/{{$portfolio->Thumbnail}}" title="test">

                                @if(sizeof($images))
                                    <?php
                                    foreach ($images as $image) {
                                    ?>
                                    <img width="100%" src="/image/{{$image->name}}" title="test">
                                    <?php } ?>


                                @endif

                            </div>

                            @if(session('user')&&session('user')['id']!=$portfolio->user_id&&(!session('user')['isVIP']))

                                <div class="shear_list">
                                    <ul>
                                        <li>
                                            <button class="greeneq likeButton" id="likeButton"><i
                                                        class="fa fa-spin fa-spinner " id="Loader"
                                                        style="display:none"></i><i class="icon-like"></i>إعجاب
                                            </button>
                                        </li>
                                        <li>
                                            <button class="orgnageq fofaret1" id="fofaret1"><i
                                                        class="fa fa-spin fa-spinner " id="Loader"
                                                        style="display:none"></i><i class="icon-star"></i>للمفضلة
                                            </button>
                                        </li>
                                        <li>
                                            <button class="blueeq tabelg" id="tabelg"><i class="icon-flag"></i>إبلاغ
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            @endif
                                 <?php $files = $portfolio->file; ?>

                                @if(! $files->isEmpty())
                                <div class='attachment'>
                                <div class="clearfix" ></div>
                                <div class="attachments">
                                    <span>المرفقات</span>
                                    <ul>
                                        @foreach($files as $key => $file)
                                              <a href="/download/{{$file->id}}"><h6><i class="icon-folder2"></i><span>{{$file->orginName}}</span></h6></a>

                                        @endforeach
                                    </ul>
                                </div>
                                </div>
                                @endif

                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="all_item_prof">
                        <div class="heade_div2">
                            <h2>معلومات العمل</h2>

                        </div>
                        <div class="left_side_itep">
                            <ul>
                                <li><i class="icon-view"></i><span>{{$portfolio->viewCount}}</span></li>
                                <li><i class="icon-like"></i><span id="likeCount">{{$portfolio->likeCount}}</span></li>
                                <li><i class="icon-star"></i><span
                                            id="favoriteCount">{{$portfolio->favoriteCount}}</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="all_item_prof">
                        <div class="heade_div2">
                            <h2>المهارات المستخدمة</h2>
                        </div>
                        <div class="left_side_items">
                            <ul>
                                @foreach($skills as $skill)
                                    <li>#{{$skill->name}}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="all_item_prof">
                        <div class="heade_div2">
                            <h2>شارك العمل</h2>
                        </div>
                        <div class="left_side_itemsher">

                            <div class="input_copy">
                                <input type="text" disabled name="" value="{{url('/').'/portfolio/'.$portfolio->id}}">
                                <button data-clipboard-text="{{url('/').'/portfolio/'.$portfolio->id}}" id="copyUrl">
                                    نسخ
                                </button>
                            </div>
                            <ul>
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
                            </ul>
                        </div>
                    </div>
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
                    <input type="hidden" name="user_id" value="{{session('user')['id']}}">
                    <input type="hidden" name="refer_id" value="{{$portfolio->id}}">
                    <input type="hidden" name="type" value="1">
                    @foreach($reportReasons as $key=> $reason)
                        <div class="slideTow">
                            <input type="radio" value="{{$reason->id}}"
                                   {{(!$key)?'checked':''}} id="slideTow{{$reason->id}}" name="report"/>
                            <label for="slideTow{{$reason->id}}">{{$reason->value}}</label>
                        </div>
                    @endforeach
                    <button>إرسال</button>
                </form>
            </div>
        </div>
    </section>


@endsection

@section('script')
    <script src="/front/js/clipboard/clipboard.min.js"></script>

    <script>


        var btns = document.getElementById('copyUrl');
        var clipboard = new Clipboard(btns);

        clipboard.on('success', function (e) {
            nofication_good('تم نسخ الرابط');
        });

        clipboard.on('error', function (e) {
            nofication_error('حصل خطأ أثناء عملية النسخ');
        });
        var likeButton = false;
        $('.likeButton').click(function () {
            if (!likeButton) {
                likeButton = true;
                obj = $(this);
                obj.children('#Loader').show();
                $.ajax({
                    url: '/like',
                    data: {user_id: '<?= session('user')['id'] ?>', 'refer_id': '<?= $portfolio->id ?>', type: 1},
                    dataType: 'json'
                }).done(function (data) {
                    if (data.status) {
                        nofication_good(data.msg, 1500);
                        $('#likeCount').text(parseInt($('#likeCount').text()) + 1);
                        likeButton = false;
                    } else {
                        nofication_error(data.msg, 1500);
                        $('#likeCount').text(parseInt($('#likeCount').text()) - 1);
                        likeButton = false;
                    }
                }).complete(function () {
                    obj.children('#Loader').hide();
                })
            }
        })


        var fofaret1 = false;
        $('.fofaret1').click(function () {
            if (!fofaret1) {
                fofaret1 = true;
                obj = $(this);
                obj.children('#Loader').show();
                $.ajax({
                    url: '/fovarite',
                    data: {user_id: '<?= session('user')['id'] ?>', 'refer_id': '<?= $portfolio->id ?>', type: 1},
                    dataType: 'json'
                }).done(function (data) {
                    if (data.status == 1)
                        nofication_good(data.msg, 3500);
                    else if (data.status == 2) {
                        nofication_error(data.msg, 3500);
                    } else
                        nofication_error(data.msg, 3500);
                    if (data.status == 1) {
                        $('#favoriteCount').text(parseInt($('#favoriteCount').text()) + 1);
                    } else if (data.status == 2)
                        $('#favoriteCount').text(parseInt($('#favoriteCount').text()) - 1);

                    fofaret1 = false;
                }).complete(function () {
                    obj.children('#Loader').hide();
                })
            }
        })

        var report = false;
        $('.report').submit(function (e) {
            e.preventDefault();
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
                    report = false;
                })
            }
        });
    </script>
@endsection