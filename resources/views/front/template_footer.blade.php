<?php global $setting ?>
<section class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="item_footer">
                    <div class="col-md-6 col-sm-6">
                        <div class="item_footer_first">
                            <h3 class="hed_foter">حول الموقع</h3>
                            <h2>إنجزلي</h2>
                            <p>{{ empty($setting['footer_text'])?$settings->get('footer_text')->set_data:$setting['footer_text']}}</p>
                            <p>{{$setting['siteLicense']}}</p>
                      </div>
                    </div>
                  <div class="col-md-2 col-sm-2">
                        <div class="item_footer_first">
                            <h3 class="hed_foter">روابط</h3>
                            <ul class="page_footer">
                                <li><a href="/">الرئيسية</a></li>
                                <li><a href="/page/About">من نحن</a></li>
                                <li><a href="/page/Privacy">سياسة الخصوصية</a></li>
                                <li><a href="/page/Conditions">سياسة الاستخدام</a></li>
                                <li><a href="/FAQ">الأسئلة الشائعة</a></li>
                                <li><a href="/Contact">الإتصال بنا</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <div class="item_footer_first">
                            <div class="item_footer_firstimg">
                                <a target="_blank" href="{{ empty($setting['ios'])?$settings->get('ios')->set_data:$setting['ios']}}"><img src="/front/images/Download.png" title="ios"></a>
                                <a target="_blank" href="{{ empty($setting['android'])?$settings->get('android')->set_data:$setting['android']}}"><img src="/front/images/android.png" title="android"></a>
                            </div>
                            <ul class="soial">
                               @if($setting['twitter'])<li><a target="_blank" href="{{$setting['twitter']}}"><i class="icon-twitter"></i></a></li>@else <li><a href="{{$settings->get('twitter')->set_data}}"><i class="icon-twitter"></i></a></li>@endif
                               @if($setting['facebook'])<li><a target="_blank" href="{{$setting['facebook']}}"><i class="icon-facebook"></i></a></li>@else<li><a href="{{$settings->get('facebook')->set_data}}"><i class="icon-twitter"></i></a></li>@endif
                               @if($setting['google'])<li><a target="_blank" href="{{$setting['google']}}"><i class="icon-google-plus"></i></a></li>@else<li><a href="{{$settings->get('google')->set_data}}"><i class="icon-twitter"></i></a></li>@endif
                               @if($setting['linkedin']) <li><a target="_blank" href="{{$setting['linkedin']}}"><i class="icon-linkedin2"></i></a></li>@else<li><a href="{{$settings->get('linkedin')->set_data}}"><i class="icon-twitter"></i></a></li>@endif
                            </ul>
                            <ul class="soial-pay">
                                <li><i class="fa fa-fw fa-cc-paypal"></i></li>
                                <li><i class="fa fa-fw fa-cc-visa"></i></li>
																<li><i class="fa fa-fw fa-cc-mastercard"></i></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="item_footer2">
                    <h2>{{ empty($setting['copyRights_text'])?$settings->get('copyRights_text')->set_data:$setting['copyRights_text']}}</h2>
                    <h2>{{date('Y')}}  © {{ empty($setting['copyRights'])?$settings->get('copyRights')->set_data:$setting['copyRights']}} </h2>
                </div>
            </div>
        </div>
    </div>
</section>