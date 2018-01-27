<?php global $setting;?>
@extends('front.__template')
@section('title','المشاريع')
@section('content')
    <section class="s_404">
        <div class="container">
           @include('project.'.(isset($searchType) && !empty($searchType)?$searchType:'search'))
            <div id="content" class="publicContent">
               @include('project.ajaxProjects')
            </div>
        </div>
    </section>
    @include('project.report')
@endsection
@section('script')
    <script>
        $(function () {
            $("#range").ionRangeSlider({
                hide_min_max: true,
                keyboard: true,
                dir:'rtl',
                from: 0,
                to: 10,
                type: 'double',
                values: [10000,6400, 3200, 1600, 800, 400, 200,100,50,25],
                prefix: "$",
                grid: true,
                grid_snap: true
            });
             $(".js-example-basic-multiple").select2({
                 placeholder: "الرجاء إختيار مهارة" ,
                 dir: "rtl"
             });
        });
    </script>
@endsection