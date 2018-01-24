<?php global $setting;?>
@extends('front.__template')
@section('title','الرسائل')
@section('content')
    <section class="s_massage">
        <div class="container">
            <div class="row">
                    @include('message.sidbar')
                <div class="col-md-8">
                    <div class="all_item_prof">
                        <div class="heade_div2">
                            <h2>{{$con->project->title}}</h2>
                            <div class="left_item_headersa">
                                <a href="{{encode_url('/project/'.$con->project->id,$con->project->title)}}">المشروع</a>
                            </div>
                        </div>
                        <div class="left_side_massage" id="messagesContent">
                            @if($con->messages)
                                @foreach($con->messages as $message)
                                       <div class="item_hs_ppl massagesq">
                                    <div class="img_item_ppl">
                                        <a href="/singleUser/{{$message->sender->username}}"><img src="{{($message->sender->avatar())}}"></a>
                                    </div>
                                    <div class="ifno_item_ppl">
                                        <a href="/singleUser/{{$message->sender->username}}"><h2>{{$message->sender->fullname()}}</h2></a>
                                        <p><i class="icon-time"></i>{{getFormatDaysFromDate($message->created_at)}}</p>
                                    </div>
                                    <div class="comment_ppl">
                                        <p>{{$message->content}}</p>
                                    </div>
                                           <?php $files=$message->files?>
                                           @include('message.attachment')
                                </div>
                                @endforeach
                            @endif
                                <div id="messageSection">
                           @include('message.sendForm')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <link rel="stylesheet" href="https://rawgit.com/enyo/dropzone/master/dist/dropzone.css">
    <script>
        Validator.form_validate_callback=function(isValid){
            console.log(isValid)
        };
    </script>
@endsection