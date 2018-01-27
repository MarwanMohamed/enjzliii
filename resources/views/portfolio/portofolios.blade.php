<div class="all_item_prof">
    <div class="heade_div2">
        <h2>معرض الاعمال</h2>
        <div class="left_item_header">
            @if($user_id==session('user')['id'])
                <button onclick="window.location.href='/addPortfolio'">أضف عمل</button>
            @endif
        </div>
    </div>
    <div class="item_s_profile">
        <ul id="da-thumbs" class="da-thumbs">
            @foreach($portfolios as $portfolio)
                <li>
                <a href="/portfolio/{{$portfolio->id}}">
                    <div class="img_profile" id="img_profile">
                        <img src="/image/200x200/{{$portfolio->Thumbnail}}" title="tet" />
                        <div class="div_bg">
                            <ul class="view_prof">
                                <li><i class="icon-view"></i>{{$portfolio->viewCount}}</li>
                                <li><i class="icon-like"></i>{{$portfolio->likeCount}}</li>
                            </ul>
                        </div>
                    </div>
                    <h2>{{str_limit($portfolio->title,40)}}</h2>
                </a>
            </li>
            @endforeach

        </ul>
        @if(!sizeof($portfolios))
            <p class="text-center" style="color: #9e9e9e">لم يتم اضافة أعمال</p>
        @endif
    </div>
</div>

    @include('pagination.limit_links', ['paginator' => $portfolios])