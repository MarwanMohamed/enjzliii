<div class="item_myfav">
    <div class="item_myfave">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <ul>
                    <li><a class="{{$type==2?'active':''}}" href="{{$type==2?'javascript:;':'/myFavorite?q='.$q}}">مشاريع</a></li>
                    <li><a class="{{$type==3?'active':''}}" href="{{$type==3?'javascript:;':'/myFavorite?type=freelancer&q='.$q}}" >منجزين</a></li>
                    <li><a class="{{$type==1?'active':''}}" href="{{$type==1?'javascript:;':'/myFavorite?type=portfolio&q='.$q}}" >أعمال</a></li>
                </ul>
            </div>
        </div>
       @include($include)
    </div>
</div>
<div class="publicPaginate">
@include('pagination.limit_links', ['paginator' => $favorites])
</div>
@if(!sizeof($favorites))
    <div class="searchError pagi">
        <span class="">لا يوجد نتائج </span>
    </div>
@endif