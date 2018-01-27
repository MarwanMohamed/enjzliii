
@foreach($cons as $con)
<div class="massage_itempage">
    <div class="col-md-4">
        <div class="img_massageprof9">
        <div class="img_massageprof">
            <a href="/singleUser/{{$con->friend()?$con->friend()->getId():0}}"><img src="{{$con->friend()?$con->friend()->avatar():''}}"></a>
        </div>
        <div class="text_massagepref">
             <a href="/conversation/{{$con->id}}"><p><i class="icon-user1"></i>{{$con->friend()?$con->friend()->fullname():''}}</p></a>
            <p><i class="icon-time"></i>
                 {{getFormatDaysFromDate((isset($con->lastMessage[0]))?$con->lastMessage[0]->created_at:$con->created_at)}}


            </p>
        </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="item_massageprof">
            <a href="/conversation/{{$con->id}}"><h2>{{$con->project->title}}</h2></a>
            <a href="/conversation/{{$con->id}}"><p>{{str_limit(((isset($con->lastMessage[0]))?$con->lastMessage[0]->content:$con->project->description),120)}}</p></a>
        </div>
    </div>
</div>
@endforeach

@if(!sizeof($cons))
    <div class="massage_itempage">
        <h2 style="margin:100px  40%">لا يوجد بيانات</h2>
    </div>
 @endif
<div class="publicPaginate">
@include('pagination.limit_links', ['paginator' => $cons])
</div>