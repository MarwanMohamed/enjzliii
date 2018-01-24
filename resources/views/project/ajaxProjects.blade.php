<div class="result_search">
    <!-- <div class="table-responsive"> -->
    @if(sizeof($projects))

    <table class="table table-striped">
        <thead>
        <tr>
            <th width="60%">المشاريع</th>
            <th class="hidden-xs">العروض</th>
            <th class="hidden-xs">الميزانية</th>
            <th class="hidden-xs">مدة التنفيذ</th>
            <th class="hidden-xs">خيارات</th>
        </tr> 
        </thead>
        <tbody>

        @foreach($projects as $project)
            <tr>
            <td>
                <div class="con_tab">
                    <a href="{{encode_url('/project/'.$project->id,$project->title)}}"><h2>{{$project->title}}</h2></a>
                    <ul>
                         @if(!$project->isVIP)
                             <li><a href="/singleUser/{{$project->owner?$project->owner->getId():''}}"><p><i class="icon-user1"></i>{{_c($project->owner,'fname').' '. _c($project->owner,'lname')}}</p></a></li>
                        @else
                              <li><a href="/singleUser/{{$project->owner?$project->VIPOwner->getId():''}}"><p><i class="icon-user1"></i>{{_c($project->VIPOwner,'fname').' '. _c($project->VIPOwner,'lname')}}</p></a></li>
                        @endif
                        <li><p><i class="icon-time"></i>{{getFormatDaysFromDate($project->created_at)}}</p></li>
                        <li><p class="hids_xssa"><i class="icon-moneybag"></i>{{$project->budget->fBudget() }}</p></li>
                        @if($project->isVIP)<li><p><i class="fa fa-cog"></i> المشروع مدار من قبل <b style='font-weight:bold'>انجزلي سوبر</b></p></li>@endif
                    </ul> 
                </div> 
                <div class="dropdown  {{($project->projectOwner_id==session('user')['id']||session('user')['id']===$project->VIPUser)?'hidden':''}} hids_xssa">
                    <button class="dropdown-toggle" type="button" data-toggle="dropdown">خيارات
                        <span class="caret menuLoader"></span></button>
                    <ul class="dropdown-menu ">
                        <li class="project"><a href="{{encode_url('/project/'.$project->id,$project->title)}}#addBids"><i class="icon-plus"></i>أضف عرضك</a></li>
                        <li class="project"><a href="/favorite?refer_id={{$project->id}}&type=2" class="ajaxRequest"><i class="icon-star"></i><span>{{$project->favorite?'الغاء التفضيل':'اضف للمفضلة'}}</span></a></li>
                        <li class="project"><a href="javascript:; " data-id="{{$project->id}}" class="reportShow"><i class="icon-flag"></i>إبلاغ عن المحتوى</a></li>
                    </ul>
                </div>
            </td>
            <td class="hidden-xs"><p>{{$project->bids->count()}}</p></td>
            <td class="hidden-xs">
              <h3>{{$project->budget->fBudget()}}</h3>
              <div class="dropdown  {{($project->projectOwner_id==session('user')['id']||session('user')['id']===$project->VIPUser)?'hidden':''}} hids_xssa">
                    <button class="dropdown-toggle" type="button" data-toggle="dropdown">خيارات
                        <span class="caret menuLoader"></span></button>
                    <ul class="dropdown-menu ">
                        <li class="project"><a href="{{encode_url('/project/'.$project->id,$project->title)}}#addBids"><i class="icon-plus"></i>أضف عرضك</a></li>
                        <li class="project"><a href="/favorite?refer_id={{$project->id}}&type=2" class="ajaxRequest"><i class="icon-star"></i><span>{{$project->favorite?'الغاء التفضيل':'اضف للمفضلة'}}</span></a></li>
                        <li class="project"><a href="javascript:; " data-id="{{$project->id}}" class="reportShow"><i class="icon-flag"></i>إبلاغ عن المحتوى</a></li>
                    </ul>
                </div>
             </td>
            <td class="hidden-xs"><p>

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

                    </p></td>
            <td  class="hidden-xs">
                <div class="dropdown {{($project->projectOwner_id==session('user')['id']||session('user')['id']===$project->VIPUser)?'hidden':''}}">
                    <button class="dropdown-toggle" type="button" data-toggle="dropdown">خيارات
                        <span class="caret"></span></button>
                    <ul class="dropdown-menu ">
                        <li class="project" ><a href="{{encode_url('/project/'.$project->id,$project->title)}}#addBids"><i class="icon-plus"></i>أضف عرضك</a></li>
                        <li class="project" ><a href="/favorite?refer_id={{$project->id}}&type=2" class="ajaxRequest"><i class="icon-star"></i><span>{{$project->favorite?'الغاء التفضيل':'اضف للمفضلة'}}</span></a></li>
                        <li class="project" ><a href="javascript:; " data-id="{{$project->id}}" class="reportShow"><i class="icon-flag"></i>إبلاغ عن المحتوى</a></li>
                    </ul>
                </div>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    <!-- </div> -->
    @else

        <div class="searchError pagi">
            <span class="">لا يوجد مشاريع حاليا</span>
        </div>
    @endif
</div>


<div class="publicPaginate">
@include('pagination.limit_links', ['paginator' => $projects])
</div>