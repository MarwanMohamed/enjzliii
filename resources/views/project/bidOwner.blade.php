<?php global $setting?>
<style>
    .ifno_item_ppl h2{
        width: auto !important;
    }
</style>
<div class="all_item_profsingle {{$bids->lastPage()>1?'nobottom':''}}">
    <div class="heade_div2">
        <h2>العروض المقدمة</h2>
      @if(sizeof($bids))
        <div class="left_profsing">
        <span class="fa fa-spin fa-spinner hidden" id="bidsOrderLoader" style="float: right;margin: 10px 10px 0 0;"></span>
            <div class="selects4">
                <div class="dropdown">
                  <button class="btn dropdown-toggle" type="button" data-toggle="dropdown">{{isset($bidsOrder)&&$bidsOrder=='asc'?'الاقدم':'الأحدث'}}          
                  <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu">
                    <li><a href="javascript:;" data-value="desc">الأحدث</a></li>
                    <li><a href="javascript:;" data-value="asc">الاقدم</a></li>
                  </ul>
                  <input type="hidden" value="{{isset($bidsOrder)?$bidsOrder:'desc'}}" id="bidsOrder" class="drop_sel" />
                </div>
            </div>
        </div>
      @endif
    </div>
    <div class="item_h2ssps">
        @foreach($bids as $bid)
            <div class="item_hs_ppl edit_swis">
             <div class="item_hs_swis">
                <div class="img_item_ppl">
                    <a href="\singleUser\{{$bid->user->getId()}}"><img src="{{($bid->user->avatar())}}"></a>
                </div>
                <div class="ifno_item_ppl">
                    <a href="\singleUser\{{$bid->user->getId()}}"><h2>{{$bid->user->fullname()}}</h2></a>
                    <span  class="hourStyle">{{ getFormatDaysFromDate($bid->created_at)}}</span><br>
                    <ul>
                        
                        <?php $evaluate=$bid->user->stars; ?>
                       @for($i=0 ;$i<5;$i++)
                            <li class="{{($i<$evaluate)?'active':''}}"><i class="icon-star"></i></li>
                        @endfor
                    </ul>
                    <p class="show_price"><i class="fa fa-dollar"></i>{{$bid->cost}}</p>
                    <p class="show_price"><i class="icon-time"></i>{{getFormatDaysFromNumber($bid->deliveryDuration)}}</p>
                    <p><i class="icon-folder2"></i>{{$bid->user->specialization?$bid->user->specialization->name:''}}</p>
                    <p><i class="icon-location"></i>{{$bid->user->country->name}}</p>
                </div>
                <div class="comment_ppl">
                    <p style="white-space: pre-wrap;">{{$bid->letter}}</p>
                </div>
                <?php $files=$bid->file;if(sizeof($files)){ ?>
                     @include('project.attachment')
                <?php }?>
              </div>
              <div class="item_hs_swis2">
                @if($project->status==2 && !empty(session('user')))
                <div class="pull-left btn_item_done">

                  @if(!$bid->isBlock)
                        <a href="javascript:; " data-id="{{$bid->id}}" class="reportOwner customButton">تبليغ</a>
                        <a href="/conversation?user_id={{$bid->freelancer_id}}&project_id={{$bid->project_id}}" id="messaged" class="customButton">تواصل معه <span class="fa fa-spin fa-spinner hidden"  id="editLoader"></span></a>
                    <a href="javascript:;" data-name="{{$bid->user->fullname()}}" data-info="{{$bid->cost}}" data-href="/addFreelancer?bid_id={{$bid->id}}" id="chooseFreelancer" class="customButton confirmBidsClick">قبول العرض <span class="fa fa-spin fa-spinner hidden"  id="chooseFreelancerLoader"></span></a>
                  @else
                        <a href="javascript:; " class="customButton">العرض محظور</a>

                    @endif
                </div>
                @endif
              </div>
            </div>
        @endforeach
    </div>
</div>
<div id="bidsPage">
    @include('pagination.limit_links', ['paginator' => $bids])
</div>
<section class="some_error" id="some_owner_error">
    <div class="bg_some_error"></div>
    <div class="some_error_item">
        <div class="heade_div2">
            <h2>تبليغ عن عرض</h2>
            <button class="close_some"><i class="icon-delete"></i></button>
        </div>
        <div class="item_some">
            <h2>قم بإختيار احد الأسباب التالية<span>*</span></h2>
            <form action="/report" id="report">
                <input type="hidden" name="refer_id" id="referIdReport" value="0">
                <input type="hidden" name="type" value="5">
                @foreach($reportReasons as $key=> $reason)
                    <div class="slideTow">
                        <input type="radio" value="{{$reason->id}}" {{(!$key)?'checked':''}} id="slideTow{{$reason->id}}" name="report" />
                        <label for="slideTow{{$reason->id}}" >{{$reason->value}}</label>
                    </div>
                @endforeach
                <button>إرسال  <i class="fa fa-spin fa-spinner hidden" id="reportLoader"></i></button>
            </form>
        </div>
    </div>
</section>
<script>
    $(function () {
        $('body').on('click','.reportOwner',function (e) {
            e.preventDefault();
            $('#referIdReport').val($(this).data('id'));
            $('#some_owner_error').show();
        });
        $('body').on('click','.close_some',function (e) {
            e.preventDefault();
            $('.some_error').hide();
        });
        var report=false;
        $('#report').submit(function (e) {
            e.preventDefault();
            if(!report) {
                report=true;
                $('#reportLoader').removeClass('hidden');
                $.ajax({
                    url: '/report',
                    data: $(this).serialize(),
                    dataType: 'json'
                }).done(function (data) {
                    if(data.status)
                        nofication_good(data.msg, 2500);
                    else
                        nofication_error(data.msg, 2500);
                    $('#reportLoader').addClass('hidden');
                    $('.some_error').hide();
                    report=false;
                    $('#reportLoader').addClass('hidden');
                }).fail(function () {
                    myNoty('حصل خطأ ما الرجاء المحاولة مرة أخرى');
                    $('#reportLoader').addClass('hidden');
                    $('.some_error').hide();
                    report=false;
                })
            }
        });

    });
</script>
<script>
    $(function () {
        var chooseFreelancerClick=false;
        $('#chooseFreelancer1').click(function () {
            if(!chooseFreelancerClick){
                chooseFreelancerClick=true;
                $('chooseFreelancerLoader').removeClass('hidden');
                $.ajax({
                    url:$(this).data('href')
                })
            }
        });
    })
</script>