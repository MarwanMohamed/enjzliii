<div class="all_item_prof hdx3">
    <div class="heade_div2">
        <h2> احصائيات العروض</h2>
    </div>

    <div class="left_side_protfolio ">
        <ul class="list_profile">
            <li>
                <i class="icon-folder2"></i>
                <h2>كل العروض</h2>
                <p>{{$all}}</p>
            </li>
            <li>
                <i class="icon-clock"></i>
                <h2>يانتظار الموافقة</h2>

                <p>{{$awaitingConfirmationBids}}</p>
            </li>
            <li>
                <i class="icon-runer-silhouette-running-fast"></i>
                <h2>قيد التنفيذ</h2>
                <p>{{$underway}}</p>
            </li>

            <li>
                <i class="icon-loadingprocess"></i>
                <h2>مكتملة</h2>
                <p>{{$complete}}</p>
            </li>
            <li>
                <i class="icon-alarm-clock"></i>
                <h2>مستبعدة</h2>
                <p>{{$canceled}}</p>
            </li>


        </ul>
    </div>
</div>