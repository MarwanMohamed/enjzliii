<a href="/conversations" style="padding: 0;" class="mobilePrevent"><i class="icon-envelope"></i>@if(isset($templateData['unseen']) && $templateData['unseen']>0)<span>{{($templateData['unseen'])}}</span>@endif</a>
    <ul>
        @foreach($templateData['messages'] as $con)
        <li   style="@if(!$con->messages->last()->seen)background:#f5f5f5;@endif margin-right: 0px;" >
                <a href="/conversation/{{$con->messages->last()->conversation_id}}">
                    <div class="img_email">
                        <img src="{{$con->messages->last()->sender?$con->messages->last()->sender->avatar():''}}">
                    </div>
                    <div class="text_email">
                        <h2 style="font-size: 12px;color:#fe5339 ">{{!empty($con->messages->last()->sender)?$con->messages->last()->sender->fullname():'' }}</h2>
                        <h2 style="color: #9e9e9e">{{str_limit($con->messages->last()->content,35)}}</h2>
                        <p><i class="icon-time"></i>{{dateToString($con->messages->last()->created_at)}}</p>
                    </div>
                </a>
            </li>
        @endforeach
        @if(!sizeof($templateData['messages']))
            <li>
                <a href="#javascript">

                    <div class="text_email" style="padding-right:25%">
                        <p style="font-size: 18px;color: red;">لا يوجد رسائل</p>
                    </div>
                </a>
            </li>
        @else
            <li>
                <a href="/conversations" class="more_massage">
                    جميع الرسائل
                </a>
            </li>
        @endif
    </ul>