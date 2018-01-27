
<style>
  .addPortfolioDiv button{
    margin-left:0;
  }
  </style>
<div class="all_item_prof">
    <div class="heade_div2">
        <h2>معرض الاعمال</h2>
    </div>
    <div class="left_side_item {{(sizeof($portfolios)?'':'not-have')}}">
              @if(sizeof($portfolios))
        <ul>
            @foreach($portfolios as $value)
            <li>
                <a href="/portfolio/{{$value->id}}">
                    <img src="/image/200x200/{{$value->Thumbnail}}">
                    <div class="div_bg">
                        <ul class="view_prof">
                            <li><i class="icon-view"></i>{{$value->views->count()}}</li>
                            <li><i class="icon-like"></i>{{$value->likes->count()}}</li>
                        </ul>
                    </div>
                    <p class="text_work_prof">{{str_limit($value->title,30)}}</p>
                    @if($value->isBlock)
                    <p class="text_work_prof">هذا العمل محظور</p>
                    @endif
                </a>

            </li>
            @endforeach
        </ul>
        <a href="/portfolios/{{$user->id==session('user')['id']?'':$user->id}}" class="abtn_reqs">جميع الأعمال</a>
        @else
       <div class="addPortfolioDiv" style='width:100%'>
         @if($user->id!=session('user')['id'])
         <h3>
           لا يوجد أعمال
         </h3>
         @else
            <button onclick="window.location.href='/addPortfolio'" >أضف عمل</button> 
        @endif
      </div>
      
        @endif

    </div>
</div>