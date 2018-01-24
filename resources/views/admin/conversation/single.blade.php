@extends('admin._layout')
<?php global $setting; ?>
@section('title','المحادثات')
@section('subTitle','عرض بالتفصيل')
@section('content')
<style>
    .activity-list .act-thumb{
        width: 128px;
    }
    h4.fullname {
        display: inline-block;
    }
    span.content {
        /* width: 100%; */
        display: block;
        font-size: 17px;
        margin: 21px;
    }
  .side_conv h2{
    float:right;
    width:100%;
    margin-top:15px;
  }
.media {
    float: right;
    width: 100%;
}
.read-panel .media-object {
    width: 54px;
}
</style>
<div class="contentpanel">
    <div class="row">
            <div class="col-md-3 side_conv">
                       <div class="panel panel-default">
            <div class="panel-body">
                <h2>المشروع </h2>
               <h4>
                 <a style="font-size: 16px" href="/admin/projects/single/{{$conversation->project->id}}">{{$conversation->project->title}}</a>
              </h4>
                <div class="profile-location">حالة المشروع: {{projectStatus($conversation->project,$setting)}}</div>
@if($conversation->isBlock)<div class="profile-location ">هذا العرض محظور لاغاء الحظر  @if(checkPerm('unblock'))<a href='/admin/conversations/unblock/{{$conversation->id}}'>اضغط هنا</a>@endif</div>
                @endif
          </div>
                          </div>
               </div>
                <div class="side_conv col-md-9">
                                <div class="panel panel-default">
            <div class="panel-body">
                    <h2>المحادثة</h2>
                      
                    <div class="read-panel">
                        @foreach($conversation->messages as $message)
                       <?php $send=($message->sender->id==$conversation->sender->id)?true:false; ?>
                        
                        <div class="media">
                              
                                <a href="#" class="pull-left">
                                    <img alt="" src="{{$message->sender->avatar()}}" class="media-object">
                                </a>
                                <div class="media-body">
                                    <span class="media-meta pull-right">{{dateToString($message->created_at)}}</span>
                                    <h4 class="text-primary">{{$message->sender->fullname()}}</h4>
                                    <small class="text-muted">{{$message->sender->username}}</small>
                                </div>
                            </div><!-- media -->
                            <p>{{$message->content}}</p>
                            <hr>
                        @endforeach
                        @if($conversation->status==1)
                        @if(checkPerm('send'))
                        
                        <form action="/admin/conversations/send" class="form-inline mt10" method="post">
                            {{csrf_field()}}
                            <div class="row">
                                <input type="hidden" name="conversation_id" value="{{$conversation->id}}"/>
                                <div class="form-group cons" >
                                    <textarea class="form-control" required="" rows=3 maxlength="500" minlength="10" style="width:100%" name="content" placeholder="ادخل نص الرسالة" ></textarea>
                                </div>
                                <div class="masd_asdj">
                                    <label >ارسل كـ</label>
                                    <select class="form-control" name="sender_id" >
                                        <option value="0">مدير النظام</option>
                                        <option value="{{$conversation->sender->id}}">{{$conversation->sender->fullname()}}</option>
                                        <option value="{{$conversation->reciever->id}}">{{$conversation->reciever->fullname()}}</option>
                                    </select>

                                </div>
                                <div style='float:left'>
                                    <input type="submit" value="ارسل" class="btn btn-success" />
                                    <a href="/admin/conversations/" class="btn btn-info">رجوع</a>
                                </div>
                            </div>
                        </form>
                        @endif
                        @else
                        
                        <h2>هذه المحادثة منتهية</h2>
                        @endif
                    </div>

 </div>
 </div>
            </div><!-- col-sm-9 -->

    </div><!-- contentpanel -->



    @endsection
    @section('script')
    <script>
        $('form').validate();
    </script>
    @endsection