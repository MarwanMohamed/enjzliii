@extends('admin._layout')
<?php global $setting; ?>

@section('title','التحكم')
@section('subTitle','اعدادات')

@section('content')
    <link rel="stylesheet" href="/panel/css/jquery.tagsinput.css"/>

    <div class="col-md-12">
        <div class="panel panel-default">

            @if(session()->has('msg'))
                <div class="form-group">
                    <span class="alert alert-info">{{session('msg')}}</span>
                </div>
            @endif

            <div class="row">
                <div class="col-sm-12">


                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs nav-justified nav-profile">
                        <li class="{{(empty(session('settings')) && empty(session('footer')) && empty(session('super')))?'active':'' }}"><a href="#websiteInfo" data-toggle="tab"><strong>بيانات الموقع</strong></a>
                        </li>
                        <li class="{{session('settings')}}"><a href="#websiteSettings" data-toggle="tab"><strong>إعدادات المشاريع</strong></a></li>
                        <li class="{{session('footer')}}"><a href="#footerInfo" data-toggle="tab"><strong>بيانات الفوتر</strong></a></li>
                        <li class="{{session('super')}}"><a href="#superInfo" data-toggle="tab"><strong>بيانات السوبر</strong></a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane {{(empty(session('settings')) && empty(session('footer')) && empty(session('super')))?'active':'' }}" id="websiteInfo">
                            <form action="/admin/control/settings" method="post">
                                {{csrf_field()}}
                                {!!textInput('siteName',$setting['siteName'],'اسم الموقع')!!}
                                {!!textInput('siteTitle',$setting['siteTitle'],'عنوان الموقع')!!}
                                {!!textareaInput('description',$setting['description'],'وصف الموقع')!!}
                                {!!textInput('cu_email',$setting['cu_email'],'البريد الإلكتروني','email' )!!}
                                {!!textInput('contact_email',$setting['contact_email'],'البريد الإلكتروني للتواصل','email' )!!}
                                {!!textInput('home_header_text',$setting['home_header_text'],'نص الترويسة في الصفحة الرئيسة')!!}
                                {!!textareaInput('Keywords',$setting['Keywords'],'ادخل كلمات مفتاحية للموقع',"id='Keywords'" )!!}
                                <input type="hidden" name="type" value="info">

                                <button class="btn btn-primary">حفظ</button>
                            </form>
                        </div>

                        <div class="tab-pane {{session('settings')}}" id="websiteSettings">
                            <form action="/admin/control/settings" method="post">
                                {{csrf_field()}}
                                {!!numberInput('open_project_day',$setting['open_project_day'],'مدة المشاريع المفتوحة ')!!}
                                {!!numberInput('site_rate',$setting['site_rate'],'نسبة الموقع' ,'required step="0.01"')!!}
                                {!!numberInput('open_bids',$setting['open_bids'],'عدد العروض المتاحة لكل مستخدم')!!}
                                {!!numberInput('suspended_balance_day',$setting['suspended_balance_day'],'عدد ايام تعليق الأموال في الحوالات الداخلية' )!!}
                                <input type="hidden" name="type" value="settings">
                                <button class="btn btn-primary">حفظ</button>
                            </form>


                        </div>

                        <div class="tab-pane  {{session('footer')}}" id="footerInfo">
                            <form action="/admin/control/settings" method="post">
                                {{csrf_field()}}
                                {!!textInput('android',$setting['android'],'تطبيق الأندرويد','url','style="direction: ltr;"' )!!}
                                {!!textInput('ios',$setting['ios'],'تطبيق ios','url','style="direction: ltr;"' )!!}
                                {!!textInput('twitter',$setting['twitter'],'تويتر','url' ,'style="direction: ltr;"')!!}
                                {!!textInput('facebook',$setting['facebook'],'فيس يوك','url','style="direction: ltr;"' )!!}
                                {!!textInput('google',$setting['google'],'قوقل','url','style="direction: ltr;"' )!!}
                                {!!textInput('linkedin',$setting['linkedin'],'لنكد ان','url','style="direction: ltr;"' )!!}
                                {!!textInput('copyRights_text',$setting['copyRights_text'],'حقوق النشر' )!!}
                                {!!textareaInput('footer_text',$setting['footer_text'],'نص التذيل' )!!}
                                {!!textareaInput('siteLicense',$setting['siteLicense'],'ترخيص الموقع')!!}
                                <input type="hidden" name="type" value="footer">

                                <button class="btn btn-primary">حفظ</button>
                            </form>

                        </div>

                        <div class="tab-pane  {{session('super')}}" id="superInfo">
                            <form action="/admin/control/settings" method="post">
                                {{csrf_field()}}
                                {!!textareaInput('super_header_text',$setting['super_header_text'],'نص صفحة الsuper' )!!}
                                {!!textInput('super_video_url',$setting['super_video_url'],'رابط فيديو صفحة super','url' )!!}
                                {!!textareaInput('super_paragraph',$setting['super_paragraph'],'نص صفحة الsuper اسفل الفيديو' )!!}
                                {!!textInput('vip_email',$setting['vip_email'],'البريد الإلكتروني للتواصل super','email' )!!}
                                <input type="hidden" name="type" value="super">
                                <button class="btn btn-primary">حفظ</button>
                            </form>
                        </div>
                    </div><!-- tab-content -->

                </div>


                {{--<div class="col-sm-9">--}}
                {{--{!!textInput('siteName',$setting['siteName'],'اسم الموقع')!!}--}}
                {{--{!!textInput('siteTitle',$setting['siteTitle'],'عنوان الموقع')!!}--}}
                {{--{!!numberInput('open_project_day',$setting['open_project_day'],'مدة المشاريع المفتوحة ')!!}--}}
                {{--{!!numberInput('site_rate',$setting['site_rate'],'نسبة الموقع' ,'required step="0.01"')!!}--}}
                {{--{!!numberInput('open_bids',$setting['open_bids'],'عدد العروض المتاحة لكل مستخدم')!!}--}}
                {{--{!!textareaInput('description',$setting['description'],'وصف الموقع')!!}--}}
                {{--{!!textareaInput('siteLicense',$setting['siteLicense'],'ترخيص الموقع')!!}--}}
                {{--{!!textInput('home_header_text',$setting['home_header_text'],'نص الترويسة في الصفحة الرئيسة')!!}--}}
                {{--{!!textareaInput('footer_text',$setting['footer_text'],'نص التذيل' )!!}--}}
                {{--{!!textInput('android',$setting['android'],'تطبيق الأندرويد','url','style="direction: ltr;"' )!!}--}}
                {{--{!!textInput('ios',$setting['ios'],'تطبيق ios','url','style="direction: ltr;"' )!!}--}}
                {{--{!!textInput('twitter',$setting['twitter'],'تويتر','url' ,'style="direction: ltr;"')!!}--}}
                {{--{!!textInput('facebook',$setting['facebook'],'فيس يوك','url','style="direction: ltr;"' )!!}--}}
                {{--{!!textInput('google',$setting['google'],'قوقل','url','style="direction: ltr;"' )!!}--}}
                {{--{!!textInput('linkedin',$setting['linkedin'],'لنكد ان','url','style="direction: ltr;"' )!!}--}}
                {{--{!!textInput('copyRights_text',$setting['copyRights_text'],'حقوق النشر' )!!}--}}
                {{--{!!textInput('cu_email',$setting['cu_email'],'البريد الإلكتروني','email' )!!}--}}
                {{--{!!textInput('contact_email',$setting['contact_email'],'البريد الإلكتروني للتواصل','email' )!!}--}}
                {{--{!!numberInput('suspended_balance_day',$setting['suspended_balance_day'],'عدد ايام تعليق الأموال في الحوالات الداخلية' )!!}--}}
                {{--{!!textareaInput('super_header_text',$setting['super_header_text'],'نص صفحة الsuper' )!!}--}}
                {{--{!!textInput('super_video_url',$setting['super_video_url'],'رابط فيديو صفحة super','url' )!!}--}}
                {{--{!!textareaInput('super_paragraph',$setting['super_paragraph'],'نص صفحة الsuper اسفل الفيديو' )!!}--}}
                {{--{!!textInput('vip_email',$setting['vip_email'],'البريد الإلكتروني للتواصل super','email' )!!}--}}
                {{--{!!textareaInput('Keywords',$setting['Keywords'],'ادخل كلمات مفتاحية للموقع',"id='Keywords'" )!!}--}}
                {{--</div>--}}
            </div>


        </div>
    </div>


@endsection
@section('script')
    <script src="/panel/js/jquery.tagsinput.min.js"></script>

    <script>
        $('form').validate();

        // Tags Input
        jQuery('#Keywords').tagsInput({width: 'auto'});

    </script>
@endsection