<div class="all_item_prof hdx3">
<div class="heade_div2">
    <h2>احصائيات المشاريع</h2>
</div>

<div class="left_side_protfolio ">
    <ul class="list_profile">
        <li>
            <i class="icon-clock"></i>
            <h2>أخر تواجد</h2>
            <?php
            $date=\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$statistics->lastLogin);
          ?>
            <p>{{dateToString($statistics->lastLogin)}}</p>
        </li>
        <li>
            <i class="icon-runer-silhouette-running-fast"></i>
            <h2>متوسط سرعة الرد</h2>
            <p>{{avgResponseSpead($statistics->responseSpeed)}}</p>
        </li>

            <li>
                <i class="icon-loadingprocess"></i>
                <h2>معدل اكمال المشاريع</h2>
                <p>{{($statistics->cancelProjectCount+$statistics->finishProjectCount)?($statistics->finishProjectCount/($statistics->cancelProjectCount+$statistics->finishProjectCount))*100 .'%':'لم يتم الحساب بعد'}}</p>
            </li>
            <li>
                <i class="icon-alarm-clock"></i>
                <h2>المشاريع قيد التنفيذ</h2>
                <p>{{$statistics->progressProjectCount}}</p>
            </li>
            <li>
                <i class="icon-folder2"></i>
                <h2>المشاريع المكتملة</h2>
                <p>{{$statistics->finishProjectCount}}</p>
            </li>
            <li>
                <i class="icon-checked"></i>
                <h2>المشاريع المستلمة</h2>
                <p>{{$statistics->deliverProjectCount}}</p>
            </li>
    </ul>
</div>
</div>