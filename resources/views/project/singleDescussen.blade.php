@foreach($descussions as $descussion)
<div class="item_hs_ppl massagesq">
    <div class="img_item_ppl ">
        <a href="/singleUser/{{$descussion->sender->getId()}}"><img src="{{$descussion->sender->avatar()}}"></a>
    </div>
    <div class="ifno_item_ppl ">
        <a href="/singleUser"><h2>{{$descussion->sender->fullname()}}</h2></a>
        <p><i class="icon-time"></i>{{getFormatDaysFromDate($descussion->created_at)}}</p>
    </div>
    <div class="comment_ppl">
        <p>{{$descussion->content}}</p>
        @foreach($descussion->file as $file)
            <a href="/download/{{$file->id}}" ><h6><i class="icon-folder2"></i>{{$file->orginName}}</h6></a>
        @endforeach
    </div>
</div>
@endforeach
