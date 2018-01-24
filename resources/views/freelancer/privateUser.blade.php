<style>
    .heade_divprof{
        margin: 0;
    }
</style>
<div class="heade_divprof">
    <input type="hidden" name="freelancer_id" value="{{$freelancer->id}}" id="">
            <div class="">
                <div class="img_divprof">
                    <a href="#"><img width="100%" height="100%" src="{{($freelancer->avatar())}}" title="user"></a>
                </div>
                <div class="text_divprof">
                    <a href="#"><h2>{{$freelancer->fname.' '.$freelancer->lname}}</h2></a>
                    <?php
                    $evaluate=($freelancer->stars);
                    ?>
                    <ul>
                        @for($i=0 ;$i<5;$i++)
                            <li class="{{($i<$evaluate)?'active':''}}"><i class="icon-star"></i></li>
                        @endfor
                        <li>{{$evaluate}}</li>
                        <h3><span><i id="{{(isOnline($freelancer->lastLogin))?'active':''}}" class="fa fa-circle" aria-hidden="true"></i></span> {{isOnline($freelancer->lastLogin)?'متصل':'غير متصل'}}</h3>
                        <h3><span><i class="icon-folder1"></i></span> {{$freelancer->specialization->name}}</h3>
                        <h3><span><i class="icon-location"></i></span> {{$freelancer->country->name}}</h3>
                </div>
            </div>
        </div>