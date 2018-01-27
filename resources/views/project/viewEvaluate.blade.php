<?php global $setting; ?>

@extends('front.__template')
@section('title','عرض التقيم')

@section('content')
    <section class="s_profile marg_tiop">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="all_item_profsingle">
                        <div class="heade_div2">
                            <h2>{{$project->title}}</h2>
                        </div>

                        <div class="divt_rate">
                            <div class="first_rate">
                                <h2>الإحترافية بالتعامل</h2>
                                <ul>
                                    @for($i=0 ;$i<5;$i++)
                                        <li class="{{($i<$evaluate->ProfessionalAtWork)?'active':''}}"><i class="icon-star"></i></li>
                                    @endfor
                                </ul>
                            </div>
                            <div class="first_rate">
                                <h2>التواصل والمتابعة</h2>
                                <ul>
                                    @for($i=0 ;$i<5;$i++)
                                        <li class="{{($i<$evaluate->CommunicationAndMonitoring)?'active':''}}"><i class="icon-star"></i></li>
                                    @endfor
                                </ul>
                            </div>
                            <div class="first_rate">
                                <h2>جودة العمل المسلّم </h2>
                                <ul>
                                    @for($i=0 ;$i<5;$i++)
                                        <li class="{{($i<$evaluate->quality)?'active':''}}"><i class="icon-star"></i></li>
                                    @endfor
                                </ul>
                            </div>
                            <div class="first_rate">
                                <h2>الخبرة بمجال المشروع </h2>
                                <ul>
                                    @for($i=0 ;$i<5;$i++)
                                        <li class="{{($i<$evaluate->experience)?'active':''}}"><i class="icon-star"></i></li>
                                    @endfor
                                </ul>
                            </div>
                            <div class="first_rate">
                                <h2>التعامل معه مرّة أخرى </h2>
                                <ul>
                                    @for($i=0 ;$i<5;$i++)
                                        <li class="{{($i<$evaluate->workAgain)?'active':''}}"><i class="icon-star"></i></li>
                                    @endfor
                                </ul>
                            </div>
                            <div class="plus_input">
                                <h2>أضف تعليق<span>*</span></h2>
                                <textarea disabled rows="6">{{$evaluate->note}}</textarea>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-4">
                    <div class="all_item_prof">
                        <div class="heade_div2">
                            <h2>تقدّم المشروع</h2>
                        </div>
                        <div class="left_side_step">
                            <ul>
                                <ol class="list-inline text-center step-indicator">
                                    <li class="complete">
                                        <div class="step"><span class="icon-checked"></span></div>
                                        <div class="caption hidden-xs hidden-sm">تلقي المنجزين</div>
                                    </li>
                                    <li class="{{($project->status<3)?'incomplete active':'complete'}} ">
                                        <div class="step">{!! ($project->status < 3)?'2':'<span class="icon-checked"></span>' !!}</div>
                                        <div class="caption hidden-xs hidden-sm">تنفيذ المشروع</div>
                                    </li>
                                    <li class="{{($project->status!=6)?'':'complete'}}  {{($project->status>=3&&$project->status!=6)?'incomplete active':''}}">
                                        <div class="step">{!! ($project->status != 6)?'3':'<span class="icon-checked"></span>' !!}</div>
                                        <div class="caption hidden-xs hidden-sm">تسليم المشروع</div>
                                    </li>
                                </ol>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <style type="text/css">
        .left_item_headersa.somaasqwe a {
            min-width: 120px;
            padding-bottom: 7px !important;
        }

        .no_top {
            border-top-color: transparent !important;
        }

        .br-widget {
            float: left !important;
        }

        .marg_tiop {
            margin-top: 40px;
        }
    </style>
@endsection

@section('script')
    <link rel="stylesheet" href="/front/css/fontawesome-stars.css">
    <link rel="stylesheet" href="/front/css/font-style.css">
    <script src="/front/js/jquery.barrating.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $(function () {
                function ratingEnable() {
                    $('.example-fontawesome').barrating({
                        theme: 'fontawesome-stars',
                        showSelectedRating: false
                    });
                    var currentRating = $('#example-fontawesome-o').data('current-rating');
                    $('.stars-example-fontawesome-o .current-rating')
                        .find('span')
                        .html(currentRating);

                    $('.stars-example-fontawesome-o .clear-rating').on('click', function (event) {
                        event.preventDefault();

                        $('#example-fontawesome-o')
                            .barrating('clear');
                    });

                    $('#example-fontawesome-o').barrating({
                        theme: 'fontawesome-stars-o',
                        showSelectedRating: false,
                        initialRating: currentRating,
                        onSelect: function (value, text) {
                            if (!value) {
                                $('#example-fontawesome-o')
                                    .barrating('clear');
                            } else {
                                $('.stars-example-fontawesome-o .current-rating')
                                    .addClass('hidden');

                                $('.stars-example-fontawesome-o .your-rating')
                                    .removeClass('hidden')
                                    .find('span')
                                    .html(value);
                            }
                        },
                        onClear: function (value, text) {
                            $('.stars-example-fontawesome-o')
                                .find('.current-rating')
                                .removeClass('hidden')
                                .end()
                                .find('.your-rating')
                                .addClass('hidden');
                        }
                    });
                }

                function ratingDisable() {
                    $('select').barrating('destroy');
                }

                $('.rating-enable').click(function (event) {
                    event.preventDefault();
                    ratingEnable();
                    $(this).addClass('deactivated');
                    $('.rating-disable').removeClass('deactivated');
                });
                $('.rating-disable').click(function (event) {
                    event.preventDefault();
                    ratingDisable();
                    $(this).addClass('deactivated');
                    $('.rating-enable').removeClass('deactivated');
                });

                ratingEnable();
            });
        });
    </script>
@endsection