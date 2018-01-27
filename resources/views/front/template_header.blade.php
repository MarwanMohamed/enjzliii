<?php global $templateData; ?>
<?php global $setting; ?>
    <meta name="Keywords" content="{{ empty($setting['Keywords'])?$settings->get('Keywords')->set_data:$setting['Keywords']}}" />
    <meta name="Description" content="{{ empty($setting['description'])?$settings->get('description')->set_data:$setting['description']}}" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta property="og:title" content="{{ empty($setting['title'])?'صفحة خطأ':$setting['title']}}" />
    @if(isset($setting['image']))
        <meta property="og:image" content="/image/{{empty($setting['image'])?$settings->get('image')->set_data:$setting['image']}}" />
    @endif
    <meta property="og:url" content="{{url()->full()}}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{empty($setting['title'])?'صفحة خطأ':$setting['title']}}" />
    <meta property="og:description" content="{{empty($setting['description'])?$settings->get('description')->set_data:$setting['description']}} " />
    <meta property="og:description" content="إنجزلي" />
