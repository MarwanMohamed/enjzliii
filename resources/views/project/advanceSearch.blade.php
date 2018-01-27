<style>
.searchButton {
    width: 130px;
    margin-top: 60px;
}
.item_div2.vew {
    padding-bottom: 0;
}
::placeholder {
    color: #787878
  }
input.select2-search__field {
    padding: 0 !important;
    line-height: 1.99999999;
}

.selects3:after, .selects3s:after, .selects2:after, .selects4:after, .selectss:after{
    content: '\e901';
    font-family: 'icomoon', sans-serif;
    color: #7e7e7e;
    font-weight: 900;
    font-size: 9px;
    position: absolute;
    left: 15px;
    top: 14px;
    z-index: 0;
}

.select2-results__options li {
    color: #8c8c8c !important;
    padding: 10px;
    border-bottom: 1px solid #f6f6f6;
}

.select2-results__options :hover {
    background-color: #f7f7f7 !important;
}
.select2-container--default .select2-results__option--highlighted[aria-selected] {
    background-color: #f7f7f7 !important;
}

</style>
<div class="heade_div404 nomars">
    <div class="heade_div2">
        <h2>المشاريع المفتوحة</h2>
        <div class="left_item_header">
            <a href="javascripts:;" class="black"><i class="icon-cogs"></i>بحث متقدم</a>
            <a href="/projects?type=fast" class="red"><i class="icon-search"></i>بحث سريع</a>
            <a href="javascripts:;" class="grean" id="reset"><i class="icon-spinner11"></i>إعادة تعيين</a>
        </div>
    </div>
    <form action="/projectsSearch" class="Ajaxsearch">
        <div class="item_div2 vew">
        <div class="search">
            <div class="row">
                <div class="col-md-4">
                    <div class="selects2">
                        <div class="dropdown">
                          <button class="btn dropdown-toggle" type="button" data-toggle="dropdown">الرجاء إختيار تخصص
                          <span class="caret"></span></button>
                          <ul class="dropdown-menu">
                            <li><a href="javascript:;" data-value="0">الرجاء إختيار تخصص</a></li>
                            @foreach($specializations as $specialization)
                            <li><a href="javascript:;" data-value="{{$specialization->id}}">{{$specialization->name}}</a></li>
                            @endforeach
                          </ul>
                          <input type="hidden" value="0" class="drop_sel" name="specialization_id" />
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="selects2">
                        <div class="dropdown">
                          <button class="btn dropdown-toggle" type="button" data-toggle="dropdown">اي مدة
                          <span class="caret"></span></button>
                          <ul class="dropdown-menu">
                            <li><a href="javascript:;" data-value="0">اي مدة</a></li>
                            <li><a href="javascript:;" data-value="1">1 - 5 يوم</a></li>
                            <li><a href="javascript:;" data-value="2">5 - 10 يوم</a></li>
                            <li><a href="javascript:;" data-value="3">10 - 25 يوم</a></li>
                            <li><a href="javascript:;" data-value="4">25 - 50 يوم</a></li>
                            <li><a href="javascript:;" data-value="5">50 - 80 يوم</a></li>
                          </ul>
                          <input type="hidden" value="0" class="drop_sel" name="deliveryDuration" />
                        </div>
                    </div>
                  
                </div>
                <div class="col-md-4">
                    <div class="selects2saw">
                    <select class="js-example-basic-multiple" id="mSelect2" multiple="multiple" name="skills[]">
                        @foreach($specializations[0]->skills as $skill)
                            <option class="skillOption" value="{{$skill->id}}" {{($skill->hasSkill)?'selected':''}}>{{$skill->name}}</option>
                        @endforeach
                    </select>
                  </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="spiled_items">
                        <div class="spiled_item">
                            <h4 style="text-align: right;">ميزانية المشروع</h4>
                        </div>
                        <div class="spiled_item2">
                            <input type="text" id="range" value="" name="budget" />
                        </div>
                    </div>
                </div>
                <div class="col-md-6" style="text-align:left;">
                    <button type="submit" class="searchButton btn">بحث  <i class="icon-search"></i></button>
                </div>
            </div>

        </div>
    </div>
    </form>
</div>
<script>
$(function(){
    $('body').on('click','#reset',function(){
        $('.dropdown').each(function(){
            $(this).children('button').text($(this).children('ul').children('li:first-child').children('a').text());
            $(this).children('input').val($(this).children('ul').children('li:first-child').children('a').data('value'));
        });
        $('#slideThree').prop('checked',false);
           $("#range").data("ionRangeSlider").update({from:0,to:500});
        $(".js-example-basic-multiple").select2('val', 'All');
                $('.Ajaxsearch').submit();
    });
})
</script>