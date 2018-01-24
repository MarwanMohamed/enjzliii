<?php global $setting;?>
@extends('front.__template')
@section('title','الرصيد')
@section('content')
    @include('front.head_statistic')
<style>
.selects2 ,.item_get_some2 p{
    margin-bottom: 15px;
}

  .plus_input input, .plus_input textarea{
    color:black;
  }
/* Center the loader */
#transactionLoader {
    position: absolute;
    left: 50%;
    top: 50%;
    z-index: 1;
    width: 150px;
    height: 150px;
    margin: -75px 0 0 -75px;
    border: 16px solid #f3f3f3;
    border-radius: 50%;
    border-top: 16px solid #FE5339;
    -webkit-animation: spin 2s linear infinite;
    animation: spin 2s linear infinite;
}

@-webkit-keyframes spin {
    0% { -webkit-transform: rotate(0deg); }
    100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Add animation to "page content" */
.animate-bottom {
    position: relative;
    -webkit-animation-name: animatebottom;
    -webkit-animation-duration: 1s;
    animation-name: animatebottom;
    animation-duration: 1s
}

@-webkit-keyframes animatebottom {
    from { bottom:-100px; opacity:0 }
    to { bottom:0px; opacity:1 }
}

@keyframes animatebottom {
    from{ bottom:-100px; opacity:0 }
    to{ bottom:0; opacity:1 }
}

</style>    
<?php global $setting;?>
<section class="s_protfolio">
        <div class="container">

            <div class="row">
                <div class="col-md-12" id="loaderDiv">
                    <div id="transactionLoader" class="hidden"></div>
                    <div class="all_item_profsingle">
                        <div class="heade_div2">
                            <h2>المعاملات المالية</h2>
                            <div class="left_item_blanc">
                                <!--$setting['min_withdraw']-->
                                @if(($user->balance-$user->suspended_balance) >= 1 )<button id="get-chash">سحب رصيد</button>@endif 
                                <button id="put-chash">شحن رصيد</button>
                            </div>
                        </div>
                        <div class="tabelesa" id="transactionDiv">
                            @include('my.transaction_item')

                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    {{-- @include('front.statistic') --}}
<!--                     @include('front.sidePortfolio') -->
                    {{-- @include('front.offers') --}}
                </div>
            </div>
        </div>
    </section>
    <section class="get_some_error">
        <div class="bg_get_some_error"></div>
        <div class="get_some_error_item">
            <div class="heade_div2">
                <h2>سحب رصيد</h2>
                <button class="close_get_some"><i class="icon-delete"></i></button>
            </div>
            <div class="item_get_some">
                <form action="/withdrawRequest" class="ajaxForm"  id="withdrawRequest" method="post">
                    <h2>حسابك على بيبال<span>*</span></h2>
                    <input type="email" required="" name="email">
                    <h2>المبلغ<span>*</span></h2>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="plus_input">
                                  <span class="input-group-btn mins">
                                      <button type="button" class="btn btn-default btn-number minus" data-type="project-days">
                                          <span class="glyphicon glyphicon-minus"></span>
                                      </button>
                                  </span>
                                {{csrf_field()}}
                                <input type="number" name="amount"   class="input-number project-days" max="{{floor($user->balance-$user->suspended_balance)}}" value="{{floor($user->balance-$user->suspended_balance)}}" min="1">
                                <span class="input-group-btn plusq">
                                      <button type="button" class="btn btn-default btn-number plus" data-type="project-days">
                                          <span class="glyphicon glyphicon-plus"></span>
                                      </button>
                                  </span>
                            </div>
                        </div>
                        <div class="col-md-4">
                          <div class="all_widas">
                            <h3><span class="dorals">$</span> دولار أمريكي</h3>
                          </div>
                        </div>
                    </div>
                    <h4>${{$user->balance-$user->suspended_balance}}</h4>
                    <button type="submit" class="item_get_somebutton">سحب رصيد
                        <i class="fa fa-spin fa-spinner" style="display: none;" id="loader"></i>
                    </button>
                    <strong><i class="icon-locked"></i>عملية السحب محمية بنظام آمني ومشفرة لمنع أي نشاط غير قانوني</strong>
                </form>
            </div>
        </div>
    </section>
    <section class="get_some_error2">
        <div class="bg_get_some_error2"></div>
        <div class="get_some_error_item2">
            <div class="heade_div2">
                <h2>شحن رصيد</h2>
                <button class="close_get_some2"><i class="icon-delete"></i></button>
            </div>
            <form class="validate ajaxForm" method="post" action="{!!  URL::route('addmoney.pay') !!}">
            <div class="item_get_some2">
                   <h2>طريقة الدفع<span>*</span></h2>
                  <div class="selects2">
                      <div class="dropdown">
                        <button class="btn dropdown-toggle" type="button" data-toggle="dropdown">paypal
                        <span class="caret"></span></button>
                        <ul class="dropdown-menu" style="width: 100%;">
                          <li><a onclick="change_curency(1)" href="javascript:;" data-value="1">paypal</a></li>
                          <li><a onclick="change_curency(2)" href="javascript:;" data-value="2">البطاقة الإتمانية</a></li>
                        </ul>
                        <input type="hidden" value="1" class="drop_sel" name="method" />
                      </div>
                  </div>
                  <h2>المبلغ<span>*</span></h2>
                  <div class="row">
                      <div class="col-md-8">
                          <div class="plus_input">
                                <span class="input-group-btn mins">
                                    <button type="button" class="btn btn-default btn-number minus" data-type="project-day">
                                        <span class="glyphicon glyphicon-minus"></span>
                                    </button>
                                </span>
                              {{csrf_field()}}
                              <input type="number" name="amount"  id="amount" class="input-number project-day" placeholder="ادخل الملبغ بالدولار" min="1">
                              <span class="input-group-btn plusq">
                                    <button type="button" class="btn btn-default btn-number plus" data-type="project-day">
                                        <span class="glyphicon glyphicon-plus"></span>
                                    </button>
                                </span>
                          </div>
                      </div>
                      <div class="col-md-4">
                       <div class="all_widas">
                          <h3 id="currency"><span class="dorals">$</span> دولار أمريكي</h3>
                      </div>
                      </div>
                  </div>
                <h2>المبلغ بعد اضافة رسوم التحويل</h2>
                <div class="row">
                    <div class="col-md-8">
                        <div class="plus_input">
                            <input  type="number" id="amountAfterDis" name="amount" placeholder="المبلغ المطلوب" class="input-number " disabled="">
                        </div>
                    </div>
                    <div class="col-md-4">
                                    <div class="all_widas">
                         <h3 id="currencyTTC"><span class="dorals">$</span> دولار أمريكي</h3>
                    </div>
                    </div>
                </div>
                <h6>المبلغ النهائي بعد اضافة رسوم إجرائية بنسبة <strong>2.9%</strong> على عملية الدفع <span>*</span> </h6>
                <p>رسوم عملية الدفع تقتطعها بوابات الدفع الالكترونية مثل PayPal والبطاقات الائتمانية</p>
                <h4 class="hidden">$522</h4>
                <button class="item_get_somebuttong">إضافة رصيد
                <i class="fa fa-spin fa-spinner" style="display: none;" id="loader"></i>
                </button>
                <strong><i class="icon-locked"></i>عملية السحب محمية بنظام آمني ومشفرة لمنع أي نشاط غير قانوني</strong>
            </div>
            </form>
        </div>
    </section>
    <section class="get_some_add" style="display: {{(session()->has('paySuccess')||session()->has('payError'))?'block':'none'}}">
        <div class="bg_get_some_add"></div>
        <div class="get_some_add_item">
            <div class="heade_div2">
                <h2>{{session()->has('paySuccessTitle')?session('paySuccessTitle'):session('payErrorTitle')}}</h2>
                <button class="close_get_some_add"><i class="icon-delete"></i></button>
            </div>
            <div class="item_get_some_add">
                <h2>{{session()->has('paySuccess')?session('paySuccess'):session('payError')}}</h2>
              <h4 >{{session('amount')}} @if(session('amount'))$ @endif</h4>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script>
        $('.validate').validate();
        chargeRate=2.9;
        $('#amount').keyup(function(){
            amount=parseInt($(this).val());
            amountAfter=amount+(amount*(chargeRate/100));
            $('#amountAfterDis').val((amountAfter));
    });
        $('#amount').change(function(){
            amount=parseInt($(this).val());
            amountAfter=amount+(amount*(chargeRate/100));
            $('#amountAfterDis').val((amountAfter));
    });
    </script>

    <script>
        $('body').on('click', '.pagination a', function(e) {
            e.preventDefault();

//            $(this).html('<i class="fa fa-spin fa-spinner Loader"></i>');
            $('#transactionLoader').removeClass('hidden');
            $('#loaderDiv').css('opacity',0.4);
            var url_string = $(this).attr('href');
            var url = new URL(url_string);
            var page = url.searchParams.get("page");

            $.ajax({
                url: '/balance?page=' + page,
                dataType: 'json'
            }).done(function (data) {
                $('#transactionLoader').addClass('hidden');
                $('#loaderDiv').css('opacity',1);
                $('#transactionDiv').html(data.view);
            });

        });

         function change_curency(t)
        {
            if(t==2){
                $("#currency,#currencyTTC").html("<span class='dorals'>XE</span> ريال سعودي");
                $('#amount').attr("placeholder","ادخل الملبغ بالريال السعودي");
            }else{
                $("#currency,#currencyTTC").html("<span class='dorals'>$</span> دولار أمريكي");
                $('#amount').attr("placeholder","ادخل الملبغ بالدولار");
            }
        }
    </script>
@endsection