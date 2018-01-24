<div class="item_hs_ppl massagesq">
    <div class="img_item_ppl">
        <a href="/singleUser/{{$message->sender->getId()}}"><img src="{{$message->sender->avatar()}}"></a>
    </div>
    <div class="ifno_item_ppl">
        <a href="/singleUser/{{$message->sender->getId()}}"><h2>{{$message->sender->fullname()}}</h2></a>
        <p><i class="icon-time"></i>{{dateToString($message->created_at)}}</p>
    </div>
    <div class="comment_ppl">
        <p>{{$message->content}}</p>
    </div>
    @include('message.attachment')
</div>
