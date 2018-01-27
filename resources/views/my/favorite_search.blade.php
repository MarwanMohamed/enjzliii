<div class="heade_div2">
    <h2>البحث في المفضلة</h2>
    <div class="left_item_header">
        <a href="#" class="red"><i class="icon-search"></i>بحث سريع</a>
    </div>
</div>
<div class="item_div2">
    <div class="col-md-6 col-md-offset-3">
        <div class="search">
            <h2>بحث سريع</h2>
            <form action="{{$url}}" class="Ajaxsearch">
            <div class="input_ad_search">
                <input type="hidden" name="type" value="{{$type1}}">
                <input type="text" name="q" value="{{(isset($q)?$q:'')}}" placeholder="البحث في المفضلة...">
                <button type="submit"><i class="icon-search"></i></button>
            </div>
            </form>
        </div>
    </div>
</div>