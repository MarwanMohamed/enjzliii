<?php global $setting;?>
@if(sizeof($favorites))
    <div class="tabl_myfacv">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>المشاريع</th>
                <th class="hidden-xs">العروض</th>
                <th class="hidden-xs">الميزانية</th>
                <th class="hidden-xs">مدة التنفيذ</th>
                <th class="hidden-xs"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($favorites as $favorite)
                <tr>
                    <td>
                        <div class="item_myfas cont_myfav">
                            <a href="{{encode_url('/project/'.$favorite->refer_id,$favorite->project->title)}}"><h2>{{$favorite->project->title}}</h2></a>
                            <span class="{{projectcolor($favorite->project,$setting)}}"><i class="{{projecticon($favorite->project,$setting)}}"></i>{{projectStatus($favorite->project,$setting)}}</span>
                            <span class="hdx"><h3>{{$favorite->project->budget->fBudget()}}</h3></span>
                            <span class="hdx"><a href="/favoriteNew?refer_id={{$favorite->project->id}}&type=2" class="cancelFavorite "><span class='fa fa-times'></span><i class="fa fa-spin fa-spinner ajaxLoader1" style="display: none"></i></a></span>
                        </div>
                    </td>
                    <td class="hidden-xs">
                        <div class="cont_myfav">
                            <p>{{$favorite->project->bids->count()}}</p>
                        </div>
                    </td>
                    <td class="hidden-xs">
                        <div class="cont_myfav">
                            <h3>{{$favorite->project->budget->fBudget()}}</h3>
                        </div>
                    </td>
                    <td class="hidden-xs">
                        <div class="cont_myfav">
                            <p>{{ getFormatDaysFromNumber($favorite->project->deliveryDuration)}}</p>
                        </div>
                    </td>
                     <td class="hidden-xs">
                        <a href="/favoriteNew?refer_id={{$favorite->project->id}}&type=2" class="cancelFavorite "><span class='fa fa-times'></span><i class="fa fa-spin fa-spinner ajaxLoader1" style="display: none"></i></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endif