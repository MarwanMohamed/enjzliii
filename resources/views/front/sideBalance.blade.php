<?php global  $setting;?>
<div class="all_item_prof hdx2s">
  
    <div class="list_myinfo">
        <ul>
            <li>
                <i class="icon-dollar-bills"></i>
                <h2>الرصيد الكلي</h2>
                <p>${{$user->balance}}</p>
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
