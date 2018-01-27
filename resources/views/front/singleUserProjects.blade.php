<?php global $setting ?>
<span></span>

@if(isset($projects))
@foreach($projects as $project)
    <tr>
        <td>
            <div class="item_myfas ">

                <a href="{{encode_url('/project/'.$project->id,$project->title)}}"><h2>{{$project->title}}</h2>
                </a>
                        <span class="{{projectcolor($project,$setting)}}"><i
                                    class="{{projecticon($project,$setting)}}"></i>{{projectStatus($project,$setting)}}</span>

                {{--{{dd(Session::get('url.intended'))}}--}}

                <div class="item_details">
                    <span><i class="icon-coins"></i> {{$project->budget->max.'$'.'-'.$project->budget->min.'$'}}</span>
                    <span><i class="fa fa-clock-o"></i> 

                        
                          @if($project->deliveryDuration == 1)
                                                    يوم
                                                @elseif($project->deliveryDuration == 2)

                                                    يومين
                                                @elseif($project->deliveryDuration >=3 && $project->deliveryDuration<= 10 )
                                                    {{$project->deliveryDuration}}
                                                    ايام
                                                @else
                                                    {{$project->deliveryDuration}}
                                                    يوماً
                                                @endif

                    </span>
                    <span><i class="fa fa-calendar"></i> {{$project->created_at->toDateString()}}</span>
                </div>

                {{--<a href="/singleUser/{{$project->owner->username}}"><p><i class="icon-user1"></i>{{$project->owner->fname.' '.$project->owner->lname}}</p></a>--}}
                {{--<p><i class="icon-time"></i>{{getFormatDaysFromDate($project->created_at)}}</p>--}}
            </div>
            <div class="hid_mobsq">


            </div>
        </td>

    </tr>
@endforeach

{{ $projects->links() }}
@endif
@if(!sizeof($projects))
    <p class="text-center" style="padding: 20px;font-size: 18px; color: #9e9e9e">لايوجد أي مشاريع</p>
@endif