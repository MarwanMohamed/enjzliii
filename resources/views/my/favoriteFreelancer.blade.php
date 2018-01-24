<?php global $setting;?>

@if(sizeof($favorites))

    <div class="tabl_myfacv">
        <!-- <div class="table-responsive"> -->

        <table class="table table-striped">
            <thead>
            <tr>
                <th class="hidden-xs">#</th>
                <th>المنجز</th>
                <th class="hidden-xs">التقيم</th>
                <th>الأعمال</th>
                <th class="">الحالة</th>
                <th class=""></th>
            </tr>
            </thead>
            <tbody>
            @foreach($favorites as $key=> $favorite)

                <tr>
                     <td class="hidden-xs">
                        <div class="item_myfas">
                            <a href="/singleUser/{{$favorite->refer_id}}"><h2>{{$key+1}}</h2></a>
                        </div>
                    </td>
                     <td>
                        <div class="cont_myfav">
                            <p><a style="color:#000" href="/singleUser/{{$favorite->user->getId()}}">{{$favorite->user->fullname()}}</a> </p>
                        </div>
                    </td>

                  <td class="hidden-xs">
                        <div class="cont_myfav">
                            <p>{{$favorite->user->stars}} </p>
                        </div>
                    </td>
                    <td class="">
                        <div class="cont_myfav">
                            <p>{{$favorite->user->portfolio->count()}}</p>
                        </div>
                    </td>
                    <td class="">
                        <div class="cont_myfav">
                            <h3>{{isOnline($favorite->user->lastLogin)?'متصل':'غير متصل'}}</h3>
                        </div>
                    </td>
                    <td>
                        <a href="/favoriteNew?refer_id={{$favorite->user->id}}&type=3" class="cancelFavorite "><i class='fa fa-times'> </i><i class="fa fa-spin fa-spinner ajaxLoader1" style="display: none"></i></a>
                    </td>
                    
                </tr>
            @endforeach
            </tbody>
        </table>

        <!-- </div> -->
    </div>
@endif