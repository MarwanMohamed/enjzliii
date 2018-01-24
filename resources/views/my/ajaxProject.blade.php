<?php global $setting ?>
@foreach($projects as $project)
    <tr>
        <td>
            <div class="item_myfas">

                <a href="{{encode_url('/project/'.$project->id,$project->title)}}"><h2>{{$project->title}}</h2>
                </a>
                <span class="{{projectcolor($project,$setting)}}"><i
                            class="{{projecticon($project,$setting)}}"></i>{{projectStatus($project,$setting)}}</span>
            </div>
        </td>
        <td class="hidden-xs">
            <div class="cont_myfav">
                <p>{{$project->bids->count()}}</p>
            </div>
        </td>
        <td>
            <div class="cont_myfav">

                @if($project->status == 6)
                    <h3>{{'$'.getFreelancer($project->id)}}</h3>
                @else
                    <h3>{{'$'.$project->budget->min.'-$'.$project->budget->max}}</h3>
                @endif
            </div>
        </td>
        <td class="hidden-xs">
            <div class="cont_myfav">
                <p>

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

                </p>
            </div>
        </td>
    </tr>
@endforeach
