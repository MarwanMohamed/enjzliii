<section class="s_404">
    <div class="container">
        <div class="heade_div404">
            @include('my.bid_search')
            <div class="">
                @include('my.bid_item')
            </div>
        </div>
    </div>
</section>
<section class="s_profile">
    <div class="container">
        <div class="publicPaginate">
            @include('pagination.limit_links', ['paginator' => $bids])
        </div>
    </div>
</section>