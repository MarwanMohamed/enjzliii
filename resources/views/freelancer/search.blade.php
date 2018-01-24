<div class="heade_div404">
    <div class="heade_div2">
        <h2>البحث عن منجزين المشاريع</h2>
        <div class="left_item_header">
            <a href="/freelancerSearch{{isset($project_id)?'/'.$project_id:''}}" class="black"><i class="icon-settings"></i>بحث متقدم</a>
            <a href="javascript:;" class="red"><i class="icon-search"></i>بحث سريع</a>
            <a href="javascript:;" id='reset' class="grean"><i class="icon-spinner11"></i>إعادة تعيين</a>
        </div>
    </div>
    <div class="item_div2">
        <div class="col-md-6 col-md-offset-3">
            <div class="search">
<!--                 <h2>بحث سريع</h2> -->
                <form action="/freelancers{{isset($project_id)?'/'.$project_id:''}}" class="Ajaxsearch">
                    <div class="input_ad_search">
                        <input type="text" name="q" value="{{$q}}" placeholder="البحث عن منجز...">
                        <button><i class="icon-search"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
$(function(){
    $('body').on('click','#reset',function(){
       // $(this).children('i').addClass('fa-spin');
        $('.Ajaxsearch :input[name=q]').val('');
        $('.Ajaxsearch button').click();
    });
})
</script>
