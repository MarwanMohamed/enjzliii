@if(sizeof($files))
<div class='attachment'>
<div class="clearfix" ></div>
<div class="attachments">
    <span>المرفقات</span>
    <ul>
        @foreach($files as $key => $file)
              <a href="/download/{{$file->id}}"><h6><i class="icon-folder2"></i><span>{{$file->orginName}}</span></h6></a>

        @endforeach
    </ul>
</div>
</div>
@endif