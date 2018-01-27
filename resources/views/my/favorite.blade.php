<?php global $setting;?>
@extends('front.__template')
@section('title','مفضلتي')
@section('content')
    <section class="s_404">
        <div class="container">
            <div class="heade_div404">
                <div class="heade_div2">
                    <h2>البحث في المفضلة</h2>
                    {{--<div class="left_item_header">--}}
                        {{--<a href="#" class="red"><i class="icon-search"></i>بحث سريع</a>--}}
                    {{--</div>--}}
                </div>
                <div class="item_div2">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="search">
                            <h2>بحث سريع</h2>
                            <form action="{{$url}}" class="Ajaxsearch">
                                <div class="input_ad_search">
                                    <input type="hidden" name="type" value="{{$type1}}">
                                    <input type="text" name="q" value="{{(isset($q)?$q:'')}}" placeholder="البحث في المفضلة...">
                                    <button type="submit"><i class="icon-search"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="publicContent">
                @include('my.item')
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script>
       var ajax=false;
        $(function () {
           $('body').on('click','.cancelFavorite',function (e) {
               e.preventDefault();
               if(!ajax){
                obj =$(this);     
                   ajax=true;
                   obj.find('.ajaxLoader1').show();
                   $.ajax({
                       url:$(this).attr('href')
                   }).done(function(data){
                       if(data.status){
                           nofication_good(data.msg);
                       }else{
                           nofication_error(data.msg);
                       }
                        obj.parent().parent().remove();
                       ajax=false;
                         obj.find('.ajaxLoader1').hide();
                   }).fail(function () {
                       myNoty('حصل خطأ ما');
                       $('.ajaxLoader1').hide();
                       ajax=false;
                   });
               }else{
                   myNoty('الرجاء انتظار جلب البيانات');
               }
           });
        });
    </script>
@endsection