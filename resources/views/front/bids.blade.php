<?php
$exist = 0;
?>

@foreach($bids as $bid)
    @if(isset($type))
        @if($type == 'الكل')
            @php
                $exist=1
            @endphp
            <div class="first_item_h2s">
                {{--<a href="{{encode_url('/project/'.$bid->project_id,$bid->project_title)}}#addBidContent"><h2>{{$bid->project_title}}</h2></a>--}}
                <a href="{{encode_url('/project/'.$bid->project->id,$bid->project->title)}}#addBidContent">
                    <h2>{{$bid->project->title}}</h2></a>
                <div class="hid_mobsq">
                    <span class="{{bidcolor($bid,$bid->project,$setting)}}"><i
                                class="{{bidicon($bid,$bid->project,$setting)}}"></i>{{bidStatus($bid,$bid->project,$setting)}}</span>
                    <a href="/singleUser/{{$bid->project->owner->username}}"><p><i class="icon-user1"></i>{{$bid->project->owner->fname.' '.$bid->project->owner->lname}}</p></a>
                    <p><i class="icon-time"></i>{{getFormatDaysFromDate($bid->created_at)}}</p>
                </div>

            </div>
        @elseif($type == bidStatus($bid,$bid->project,$setting))
            @php
                $exist=1
            @endphp

            <div class="first_item_h2s">
                {{--<a href="{{encode_url('/project/'.$bid->project_id,$bid->project_title)}}#addBidContent"><h2>{{$bid->project_title}}</h2></a>--}}
                <a href="{{encode_url('/project/'.$bid->project->id,$bid->project->title)}}#addBidContent">
                    <h2>{{$bid->project->title}}</h2></a>
                <div class="hid_mobsq">
                    <span class="{{bidcolor($bid,$bid->project,$setting)}}"><i
                                class="{{bidicon($bid,$bid->project,$setting)}}"></i>{{bidStatus($bid,$bid->project,$setting)}}</span>
                    <a href="/singleUser/{{$bid->project->owner->username}}"><p><i class="icon-user1"></i>{{$bid->project->owner->fname.' '.$bid->project->owner->lname}}</p></a>
                    <p><i class="icon-time"></i>{{getFormatDaysFromDate($bid->created_at)}}</p>
                </div>

            </div>
        @endif
    @else
        <div class="first_item_h2s">
            {{--<a href="{{encode_url('/project/'.$bid->project_id,$bid->project_title)}}#addBidContent"><h2>{{$bid->project_title}}</h2></a>--}}
            <a href="{{encode_url('/project/'.$bid->project->id,$bid->project->title)}}#addBidContent">
                <h2>{{$bid->project->title}}</h2></a>
            <div class="hid_mobsq">
                <span class="{{bidcolor($bid,$bid->project,$setting)}}"><i
                            class="{{bidicon($bid,$bid->project,$setting)}}"></i>{{bidStatus($bid,$bid->project,$setting)}}</span>
                <a href="/singleUser/{{$bid->project->owner->username}}"><p><i class="icon-user1"></i>{{$bid->project->owner->fname.' '.$bid->project->owner->lname}}</p></a>
                <p><i class="icon-time"></i>{{getFormatDaysFromDate($bid->created_at)}}</p>
            </div>

        </div>
    @endif
@endforeach
@if(!isset($type))
    @if(!sizeof($bids))
        <p class="text-center" style="padding: 20px;font-size: 18px; color: #9e9e9e" >لايوجد أي عروض</p>
    @endif
@else
    @if($exist ==0)

        <p class="text-center" style="padding: 20px;font-size: 18px; color: #9e9e9e">لايوجد أي عروض</p>
    @endif
@endif

<div class="bidsPage">{{$bids->links()}}</div>