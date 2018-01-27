<div class="heade_div404 nomars">
    <div class="heade_div2">
        <h2>المشاريع المفتوحة</h2>
        <div class="left_item_header">
            <a href="/projectsSearch" class="black"><i class="icon-cogs"></i>بحث متقدم</a>
            <a href="javascripts:;" class="red"><i class="icon-search"></i>بحث سريع</a>
            <a href="javascripts:;" class="grean" id="reset"><i class="icon-spinner11"></i>إعادة تعيين</a>
        </div>
    </div>
    <div class="item_div2">
        <div class="col-md-6 col-md-offset-3">
            <div class="search">
<!--                 <h2>بحث سريع</h2> -->
                <div class="input_ad_search">
                    <form class="Ajaxsearch" action="/projects" method="get">
                        <input type="text" name="q" value="{{isset($q)?$q:''}}" placeholder="البحث عن مشروع...">
                        <button><i class="icon-search"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="clearfix"></div>

<script>
$(function(){
    $('body').on('click','#reset',function(){
       // $(this).children('i').addClass('fa-spin');
        $('.Ajaxsearch :input[name=q]').val('');
        $('.Ajaxsearch button').click();
    });
})
</script>