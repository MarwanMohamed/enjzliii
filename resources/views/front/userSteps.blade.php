
<?php
$step=check_steps($user);
?><div class="all_item_prof">
    <div class="heade_div2">
        <h2>خطوات أكمال  الملف الشخصي</h2>
    </div>
    <div class="left_side_item3">
        <ul>
            @foreach($step as $key=>$value)
            @if($value)
                 <li><a href="javascript:;"><i class="icon-checked"></i>{{trans('lang.'.$key)}}</a></li>
            @else
                 <li><a class="not_active" href="{{stepUrl($key)}}"><i class="icon-delete"></i>{{trans('lang.'.$key)}}</a></li>
            @endif
            @endforeach
        </ul>
    </div>
</div>

