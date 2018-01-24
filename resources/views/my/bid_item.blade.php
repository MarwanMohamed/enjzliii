<?php global $setting ?>
<div class="item_myfav">
    <div class="item_myfaves">
        <div class="row">
            <div class="col-md-12 ">
                <ul>
                    <li><a class="{{$type==0?'active':''}}" href="/myBids">كل العروض</a></li>
                    <li><a class="{{$type==1?'active':''}}" href="/myBids/1">بإنتظار الموافقة</a></li>
                    <li><a class="{{$type==2?'active':''}}" href="/myBids/2">قيد التنفيذ</a></li>
                    <li><a class="{{$type==3?'active':''}}" href="/myBids/3">مكتملة</a></li>
                    <li><a class="{{$type==4?'active':''}}" href="/myBids/4">ملغية</a></li>
                    <li><a class="{{$type==5?'active':''}}" href="/myBids/5">مغلقة</a></li>
                    <li><a class="{{$type==6?'active':''}}" href="/myBids/6">مستبعدة</a></li>
                    <li><a class="{{$type==7?'active':''}}" href="/myBids/7">محظورة</a></li>
                </ul>
            </div>
        </div>

        <div class="tabl_myfacv">
            <!-- <div class="table-responsive"> -->
            <table class="table table-striped">
                <thead>
                <tr>
                    <th width="70%">المشاريع</th>
                    <th class="hidden-xs">العروض</th>
                    <th>قيمة العرض</th>
                    <th class="hidden-xs">مدة التنفيذ</th>
                </tr>
                </thead>
                <tbody>
                @foreach($bids as $bid)
                    @if($statusType == 'الكل')
                        <tr>
                            <td>
                                <div class="item_myfas">
                                    <a href="{{encode_url('/project/'.$bid->project->id,$bid->project->title)}}#addBidContent">
                                        <h2>{{$bid->project->title}}</h2></a>
                                    <span class="{{bidcolor($bid,$bid->project,$setting)}}"><i
                                                class="{{bidicon($bid,$bid->project,$setting)}}"></i>{{bidStatus($bid,$bid->project,$setting)}}</span>
                                </div>
                            </td>
                            <td class="hidden-xs">
                                <div class="cont_myfav">
                                    <p>{{$bid->project->bids->count()}}</p>
                                </div>
                            </td>
                            <td>
                                <div class="cont_myfav">
                                    <h3>{{'$'.$bid->cost}}</h3>
                                </div>
                            </td>
                            <td class="hidden-xs">
                                <div class="cont_myfav">
                                    <p>

                                        @if($bid->deliveryDuration == 1)
                                            يوم
                                        @elseif($bid->deliveryDuration == 2)
                                            يومين
                                        @elseif($bid->deliveryDuration >=3 && $bid->deliveryDuration<= 10 )
                                            {{$bid->deliveryDuration}}
                                            ايام
                                        @else
                                            {{$bid->deliveryDuration}}
                                            يوماً
                                        @endif
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @elseif($statusType == bidStatus($bid,$bid->project,$setting))
                        <tr>
                            <td>
                                <div class="item_myfas">
                                    <a href="{{encode_url('/project/'.$bid->project->id,$bid->project->title)}}#addBidContent">
                                        <h2>{{$bid->project->title}}</h2></a>
                                    <span class="{{bidcolor($bid,$bid->project,$setting)}}"><i
                                                class="{{bidicon($bid,$bid->project,$setting)}}"></i>{{bidStatus($bid,$bid->project,$setting)}}</span>
                                </div>
                            </td>
                            <td class="hidden-xs">
                                <div class="cont_myfav">
                                    <p>{{$bid->project->bids->count()}}</p>
                                </div>
                            </td>
                            <td>
                                <div class="cont_myfav">
                                    <h3>{{'$'.$bid->cost}}</h3>
                                </div>
                            </td>
                            <td class="hidden-xs">
                                <div class="cont_myfav">
                                    <p>

                                        @if($bid->deliveryDuration == 1)
                                            يوم
                                        @elseif($bid->deliveryDuration == 2)
                                            يومين
                                        @elseif($bid->deliveryDuration >=3 && $bid->deliveryDuration<= 10 )
                                            {{$bid->deliveryDuration}}
                                            ايام
                                        @else
                                            {{$bid->deliveryDuration}}
                                            يوماً
                                        @endif
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
            <!-- </div> -->
        </div>
    </div>
</div>
@if(!sizeof($bids))
    <div class="searchError pagi">
        <span class="">لا يوجد أي عروض </span>
    </div>
@endif