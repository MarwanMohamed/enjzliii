<?php global $setting; ?>
@extends('front.__template')
@section('title','تقيم منجز المشروع')
@section('content')
<style>
.plus_input.new-evlut {
    padding: 20px;
}
.plus_input.new-evlut h2 {
    font-size: 15px;
    margin-bottom: 5px;
}
</style>
    <section class="s_profile marg_tiop">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="all_item_profsingle">
                        <div class="heade_div2">
                            <h2>{{$project->title}}</h2>
                        </div>
                        <form action="/evaluate" method="post" class="ajaxForm">
                            <div class="item_h2ss">
                                <input type="hidden" name="id" value="{{isset($evaluate)?$evaluate->id:0}}">
                                <input type="hidden" name="project_id" value="{{isset($project)?$project->id:0}}">
                                {{csrf_field()}}
                                <div class="divt_rate no_top">
                                    <div class="first_rate">

                                        <h2>الإحترافية بالتعامل</h2>
                                        <select class="example-fontawesome" name="ProfessionalAtWork" autocomplete="off">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                    <div class="first_rate">
                                        <h2>التواصل والمتابعة</h2>
                                        <select class="example-fontawesome" name="CommunicationAndMonitoring" autocomplete="off">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                    <div class="first_rate">
                                        <h2>جودة العمل المسلّم </h2>

                                        <select class="example-fontawesome" name="quality" autocomplete="off">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                    <div class="first_rate">
                                        <h2>الخبرة بمجال المشروع </h2>

                                        <select class="example-fontawesome" name="experience" autocomplete="off">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                    <div class="first_rate">
                                        <h2>التعامل معه مرّة أخرى </h2>

                                        <select class="example-fontawesome" name="workAgain" autocomplete="off">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                    <div class="plus_input new-evlut">
                                        <h2>أضف تعليق<span>*</span></h2>
                                        <textarea required name="note" rows="6"></textarea>
                                    </div>
                                    <div class="btn_ok">
                                        <button>قيم  <i class="fa fa-spin fa-spinner" id="loader" style="display: none"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
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
                                        <div class="caption hidden-xs hidden-sm">تلقي المتقدمين</div>
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