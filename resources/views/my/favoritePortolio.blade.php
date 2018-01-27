<?php global $setting;?>

@if(sizeof($favorites))

    <div class="tabl_myfacv">
        <!-- <div class="table-responsive"> -->

        <table class="table table-striped">
            <thead>
            <tr>
                <th>الأعمال</th>
                <th class="hidden-xs">المشاهدات</th>
                <th>الإعجابات</th>
                <th class="hidden-xs">تاريخ الإنتهاء</th>
                <th class=""></th>
            </tr>
            </thead>
            <tbody>
            @foreach($favorites as $favorite)

                <tr>
                    <td>
                        <div class="item_myfas">
                            <a href="/portfolio/{{$favorite->refer_id}}"><h2>{{$favorite->portfolio->title}}</h2></a>
                        </div>
                    </td>
                    <td class="hidden-xs">
                        <div class="cont_myfav">
                            <p>{{$favorite->portfolio->views->count()}}</p>
                        </div>
                    </td>
                    <td>
                        <div class="cont_myfav">
                            <h3>{{$favorite->portfolio->likes->count()}}</h3>
                        </div>
                    </td>
                    <td class="hidden-xs">
                        <div class="cont_myfav">
                            <p>{{$favorite->portfolio->accomplishDate}}</p>
                        </div>
                    </td>
                    <td>
                        <a href="/favoriteNew?refer_id={{$favorite->portfolio->id}}&type=1" class="cancelFavorite "><span class='fa fa-times'></span><i class="fa fa-spin fa-spinner ajaxLoader1" style="display: none"></i></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <!-- </div> -->
    </div>
@endif