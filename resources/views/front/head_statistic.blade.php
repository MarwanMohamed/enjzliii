<?php global $setting?>
<section class="s_404">
    <div class="container">
         <style>
        .list_profile1 li{
            width: 18%;
        }
    </style>
        <div class="heade_divprof">
            <div class="first_divprof">
                <div class="img_divprof">
                    <a href="#"><img width="120" class="avatarImage" height="120" src="{{avatar($user->avatar,$setting)}}" title="user"></a>
                </div>
                <div class="text_divprof">
                    <a href="#"><h2 class='fullname'>{{$user->fname.' '.$user->lname}}</h2></a>
                                          <?php $evaluate=session('user')['stars']; ?>

                    <ul>
                        @for($i=0 ;$i<5;$i++)
                            <li class="{{($i<$evaluate)?'active':''}}"><i class="icon-star"></i></li>
                        @endfor
                        <li>{{$evaluate}}</li>
                    </ul>
                    <h3><span><i id="active" class="icon-error" aria-hidden="true"></i></span> متصل</h3>
                    <h3><span><i class="icon-folder1"></i></span>{{$user->specialization_name}}</h3>
                    <h3><span><i class="icon-location"></i></span> {{$user->country_name}}</h3>
                    <h3><span><i class="fa fa-address-book-o"></i></span> {{(getUserType($user->type))}}</h3>
                </div>
            </div>
            <ul class="list_profile  list_profile1 left_item">
                <li>
                    <i class="icon-dollar-bills"></i>
                    <h2>الرصيد الكلي</h2>
                    <p>${{number_format($user->balance,2)}}</p>
                </li>
                <li>
                    <i class="icon-euromoneybag"></i>
                    <h2>الرصيد المعلق</h2>
                    <p>${{number_format($user->suspended_balance,2)}}</p>
                </li>
                <li>
                    <i class="icon-wallet"></i>
                    <h2>الرصيد القابل للسحب</h2>
                    <p>${{number_format($user->balance-$user->suspended_balance,2)}}</p>
                </li>
            </ul>
        </div>
    </div>
</section>