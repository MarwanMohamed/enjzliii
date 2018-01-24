<div class="item_hs_ppl">
    <div class="img_item_ppl">
        <a href="\singleUser\{{$userBid->user->getId()}}"><img src="{{$userBid->user->avatar()}}"></a>
    </div>
    <div class="ifno_item_ppl">
        <a href="\singleUser\{{$userBid->user->getId()}}"><h2>{{$userBid->user->fullname()}}</h2></a>


        <ul>
            <?php $evaluate=($userBid->user->stars); ?>
            @for($i=1;$i<=5;$i++ )
                @if($i<$evaluate)
                    <li class="active"><i class="icon-star"></i></li>
                @else
                    <li><i class="icon-star"></i></li>
                @endif
            @endfor
        </ul>
        <p><i class="fa fa-dollar"></i>{{$userBid->cost}}</p>
        <p><i class="icon-time"></i>{{getFormatDaysFromNumber($userBid->deliveryDuration)}}</p>
        <p><i class="icon-folder2"></i>{{$userBid->user->specialization->name}}</p>
        <p><i class="icon-location"></i>{{$userBid->user->country->name}}</p>
    </div>
  @if($project->status==2)
        <a href="javascript:;" style="margin-left: 8px;" data-href="/editBid/{{$userBid->id}}" id="editBid" class="customButton">تحرير <span class="fa fa-spin fa-spinner hidden"  id="editLoader"></span></a>

    @endif
  <div class="comment_ppl">
        <p style="white-space: pre-wrap;">{{$userBid->letter}}</p>
    </div>
    <?php $files=$userBid->file ?>
    @include('project.attachment')
</div>

