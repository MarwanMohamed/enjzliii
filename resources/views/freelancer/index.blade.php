<?php global $setting; ?>

@extends('front.__template')
@section('title','ابحث عن منجزين')
@section('content')
    <section class="s_404">
        <div class="container">
            @include('freelancer.'.(isset($searchType)?$searchType:'search'))

        </div>
    </section>
    <section class="s_404s">
        <div class="publicContent">
            @include('freelancer.item')
        </div>
    </section>

@endsection

@section('script')
<link rel="stylesheet" href="/front/css/fontawesome-stars.css">
    <link rel="stylesheet" href="/front/css/font-style.css">
    <script src="/front/js/jquery.barrating.js"></script>
    <script>
        $(function () {
            $(".js-example-basic-multiple").select2({
                placeholder: "الرجاء إختيار مهارة",
                dir: "rtl"
            });
            
            $('#addvanceSearch :input ,#addvanceSearch select').change(function () {
               $('#addvanceSearch').submit();
            });

            $('#addvanceSearch').submit(function (e) {
                e.preventDefault();
                $('#searchLoader').fadeIn();
                url=$(this).attr('action');
                fullURL=url+'?'+$(this).serialize();
                $.ajax({
                    url:url,
                    data:$(this).serialize()
                }).done(function(data){
                    if(data.status){
                        $('.publicContent').html(data.view);
                    }else
                        myNoty(data.msg);
                    $('#searchLoader').fadeOut();
                }).fail(function(){
                    myNoty('حصل خطأ ما');
                    $('#searchLoader').fadeOut();
                });
            });
        });
      
      
      
      
      
      
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
    </script>
    @include('freelancer.report')


@endsection