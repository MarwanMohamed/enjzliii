<style>
    div.stars {
        padding: 0 5px;
        display: inline-block;
        margin-bottom: -6px;
    }

    input.star { display: none; }

    label.star {
        float: left;
        padding: 0 5px;
        font-size: 24px;
        color: #444;
        transition: all .2s;
    }

    input.star:checked ~ label.star:before {
        content: '\f005';
        color: #ffc107;
        transition: all .25s;
    }

    input.star:hover ~ label.star:before {
        content: '\f005';
        color: #ffc107;
        transition: all .25s;
    }



    input.star-1:checked ~ label.star:before { color: #F62; }


    label.star:before {
        content: '\f006';
        font-family: FontAwesome;
    }
    .search label.ev ,.search .stars label{
        width: auto;
    }

  .br-widget a:first-child {
      display:none;
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
<div class="heade_div404">
    <base href="">
    <div class="heade_div2">
        <h2> البحث عن منجزين </h2>
        <h2 style="padding-right:0 ;"> <i id="searchLoader" class="fa fa-spin fa-spinner " style="font-size: 24px;display: none;"></i></h2>
        <div class="left_item_header">
            <a href="javascript:;" class="black"><i class="icon-settings"></i>بحث متقدم</a>
            <a href="/freelancers" class="red"><i class="icon-search"></i>بحث سريع</a>
            <a href="javascript:;" class="grean" id="reset"><i class="icon-spinner11"></i>إعادة تعيين</a>
        </div>
    </div>
    <form action="/freelancerSearch" id="addvanceSearch">
    <div class="item_div2">
        <div class="search">
            <div class="row">
                <div class="col-md-4">
                  <div class="selects2">
                    <div class="dropdown">
                      <button class="btn dropdown-toggle" type="button" data-toggle="dropdown"> الرجاء إختيار تخصص
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
                        <button class="btn dropdown-toggle" type="button" data-toggle="dropdown"> الرجاء إختيار دولة
                        <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="javascript:;" data-value="0">الرجاء إختيار دولة</a></li>
                          @foreach($countries as $country)
                          <li><a href="javascript:;" data-value="{{$country->id}}">{{$country->name}}</a></li>
                          @endforeach
                        </ul>
                        <input type="hidden" value="0" class="drop_sel" name="country_id" />
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                  <div class="all_widas">
                    <select class="js-example-basic-multiple " name="skills[]" id="skillsinput" multiple="" >


                        @foreach($specializations[0]->skills as $skill)
                            <option class="skillOption" value="{{$skill->id}}" {{($skill->hasSkill)?'selected':''}}>{{$skill->name}}</option>
                            <hr>
                        @endforeach
                    </select>
                </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4" >
                                    <div class="all_widas">
                  <div class="first_rate">

                                        <h2>التقييم :</h2>
                                        <select class="example-fontawesome star"  name='star' name="ProfessionalAtWork" autocomplete="off">
                                            <option value="0"></option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                          <a href="javascript:;" onclick="$('.br-widget a').removeClass('br-selected');$('.star option:selected').removeAttr('selected');$('.star').change()" style=" margin: 12px 10px;color: #fe5339;"><i class="fa fa-close"></i></a>

                                    </div>

                  </div>




                </div>
                <div class="col-md-4 hidden " >
                    <label>التقييم:</label>
                        <ul>
                            <li class="active"><i class="icon-star"></i></li>
                            <li><i class="icon-star"></i></li>
                            <li><i class="icon-star"></i></li>
                            <li><i class="icon-star"></i></li>
                            <li><i class="icon-star"></i></li>
                        </ul>
                        <button><i class="icon-delete"></i></button>
                    </label>
                </div>
                <div class="col-md-4">
                    <label>عرض المتصلين فقط:
                        <div class="slideThree">
                            <input type="checkbox" id="slideThree" name="check"  />
                            <label for="slideThree"></label>
                        </div>
                    </label>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>



<script>
$(function(){
    $('body').on('click','#reset',function(){

       // $(this).children('i').addClass('fa-spin');
        $('.dropdown').each(function(){
            $(this).children('button').text($(this).children('ul').children('li:first-child').children('a').text());
            $(this).children('input').val($(this).children('ul').children('li:first-child').children('a').data('value'));
        });
//        $('#skillsinput option').prop('selected',false);
        $('#slideThree').prop('checked',false);

        $('.br-widget a').removeClass('br-selected');$('.star option:selected').removeAttr('selected');
        $("#skillsinput").select2('val', 'الرجاء إختيار مهارة');

    });
})
</script>
