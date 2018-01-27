<div class="col-md-4">
<div class="all_item_profsingle">
    <div class="heade_div2">
        <h2>صندوق الرسائل</h2>
    </div>
    <?php ?>
    <div class="iteme_massage">
          <ul>
              <li><a class="{{(isset($fillter)&&$fillter=='all')?'active':''}}" href="/conversations?fillter=all"><i class="icon-mail"></i>@if(isset($unseen->allCount))<strong>{{$unseen->allCount}}</strong>@endifجميع الرسائل @if(isset($conSta->allCount))<span>{{$conSta->allCount}}</span>@endif</a></li>
              @if(!session('user')['isVIP'])<li><a class="{{(isset($fillter)&&$fillter=='sent')?'active':''}}" href="/conversations?fillter=sent"><i class="icon-mail-sent"></i>@if(isset($unseen->allCount))<strong>{{$unseen->allCount-$unseen->revive}}</strong>@endifالرسائل الصادرة@if(isset($conSta->allCount))<span>{{$conSta->allCount-$conSta->revive}}</span>@endif</a></li>
              <li><a class="{{(isset($fillter)&&$fillter=='recieve')?'active':''}}" href="/conversations?fillter=recieve"><i class="icon-mail-sent"></i>@if(isset($unseen->recieve))<strong>{{$unseen->recieve}}</strong>@endifالرسائل الواردة@if(isset($conSta->revive))<span>{{$conSta->revive}}</span>@endif</a></li>@endif
          </ul>
    </div>
</div>
</div>