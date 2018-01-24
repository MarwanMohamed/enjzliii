<?php global  $setting;?>
<div class="all_item_prof hdx2s">
    <div class="heade_div2">
        <h2>معلوماتي</h2>
    </div>
    <div class="item_left_imgasq">
        <div class="img_left_imgasq new_edi">
            <img src="{{avatar($user->avatar,$setting)}}">
        </div>
        <div class="text_left_imgasq new_edi">
           <h2>{{$user->fname.' '.$user->lname}}</h2>
            <?php
            $evaluate=number_format(($user->ProfessionalAtWork+
                            $user->CommunicationAndMonitoring+
                            $user->quality+
                            $user->experience+
                            $user->workAgain)/5,0);
            ?>
            <ul>
                @for($i=0;$i<5;$i++)
                            @if($i<$user->stars)
                                <li class="active"><i class="icon-star"></i></li>
                            @else
                                <li><i class="icon-star"></i></li>
                            @endif
                        @endfor
            </ul>
            <h3><span><i id="active" class="icon-error" aria-hidden="true"></i></span> متصل</h3>
            <h3><span><i class="icon-folder1"></i></span>{{$user->specialization_name}}</h3>
            <h3><span><i class="icon-location"></i></span> {{$user->country_name}}</h3>
        </div>
    </div>
    <div class="list_myinfo">
        <ul>
            <li>
                <i class="icon-dollar-bills"></i>
                <h2>الرصيد الكلي</h2>
                <p>${{$user->balance}}</p>
            </li>
            <li class="hidden">
                <i class="icon-businessman"></i>
                <h2>الرصيد المتاح</h2>
                <p>${{$user->balance-$user->suspended_balance}}</p>
            </li>
            <li>
                <i class="icon-euromoneybag"></i>
                <h2>الرصيد المعلق</h2>
                <p>${{$user->suspended_balance}}</p>
            </li>
            <li>
                <i class="icon-wallet"></i>
                <h2>الرصيد القابل للسحب</h2>
                <p>${{$user->balance-$user->suspended_balance}}</p>
            </li>
        </ul>
    </div>
</div>
