<div class="container">
    <div class="result_search">
        <div class="row">
            @foreach($freelancers as $freelancer)
     
                <div class="col-md-3 col-sm-4">
                    <div class="first_result">
                        <div class="img_result">
                            <a href="/singleUser/{{$freelancer->getId()}}"><img src="{{$freelancer->avatar()}}" title="user"></a>
                        </div>
                        <div class="text_result">

                            <a href="/singleUser/{{$freelancer->getId()}}"><h2>{{$freelancer->fullname()}}</h2></a>
                            <?php $avr = $freelancer->stars ?>
                            <ul>
                                @for($i=0;$i<5;$i++)
                                    @if($i<$avr)
                                        <li class="active"><i class="icon-star"></i></li>
                                    @else
                                        <li><i class="icon-star"></i></li>
                                    @endif
                                @endfor

                            </ul>
                            <h3><span class="{{isOnline($freelancer->lastLogin)?'active':''}}"><i
                                        class="icon-error"></i></span> {{isOnline($freelancer->lastLogin)?'متصل':'غير متصل'}}</h3>
                            <h3><span><i class="icon-folder2"></i></span>{{($freelancer->specialization)?$freelancer->specialization->name:''}}</h3>
                            <h3><span><i class="icon-location"></i></span> {{$freelancer->country?$freelancer->country->name:''}}</h3>
                        </div>
                        <div class="ul-sreaq">
                            <ul>
                                <li><a href="/{{(isset($project_id))?('inviteFreelancer/'.$project_id):'addPrivateProject'}}/{{$freelancer->id}}" class="{{(isset($project_id))?'ajaxRequest':''}}"><i class="icon-user1 Loader"></i>{{isset($project_id)?'دعوة':'اطلبني'}}</a></li>
                                <li class=""><a href="/favorite?refer_id={{$freelancer->id}}&type=3" class="ajaxRequest "><i class="icon-star  {{($freelancer->refer_id)?'active':''}} Loader " id="freelancerIcon"></i><span>{{($freelancer->refer_id)?'الغاء التفضيل':'اضف للمفضلة'}}</span></a></li>
                                <li><a href="javascript:; " data-id="{{$freelancer->id}}" class="reportShow"><i class="icon-flag"></i>تبليغ</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="publicPaginate">
        @include('pagination.limit_links', ['paginator' => $freelancers])
    </div>
    @if(!sizeof($freelancers))
    <div class="searchError pagi">
        <span class="">لا يوجد نتائج </span>
    </div>
@endif

</div>



