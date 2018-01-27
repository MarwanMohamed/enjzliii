@if(sizeof($files))
<div class="clearfix" ></div>
<div style="border-top: 1px solid #eee" >
    <span>المرفقات</span>
    <ul>
        @foreach($files as $key => $file)
            <a href="/download/{{$file->id}}"><h6><i class="icon-folder2"></i>{{$file->orginName}}<span></span></h6></a>

        @endforeach
    </ul>
</div>
@endif