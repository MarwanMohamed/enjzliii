<?php global $setting;?>
@extends('front.__template')
@section('title','الأعمال')

@section('content')
    @include('front.heade_info')
    <section class="s_profile">
        <div class="container" id="portofolios">
          @include('portfolio.portofolios')
        </div>
    </section>

@endsection

@section('script')
    <script>
        $('body').on('click','#portofolios .customPagination a',function(e){
            e.preventDefault();
            var elm=$(this);
            getPortfolios(elm.attr('href').split('page=')[1],elm);
        });

        function getPortfolios(page=1,elm) {
            elm.html('<i class="fa fa-spinner fa-spin"></i>');
            $.ajax({
                url : '/getPortfolio?id=<?=$user->id?>&page=' + page,
                dataType: 'json',
            }).done(function (data) {
                $('#portofolios').html(data.view);
                location.hash = page;
                $("body").animate({ scrollTop: $('#portofolios').offset().top }, 1000);
            }).fail(function () {
                alert('Posts could not be loaded.');
            });
        }
    </script>
@endsection