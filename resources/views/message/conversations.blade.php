
@extends('front.__template')
@section('title','المحادثات')

@section('content')
 <section class="s_massage">
        <div class="container">
            <div class="row">
                  @include('message.sidbar')
                <div class="col-md-8">
                    <div class="all_item_prof">
                        <div class="heade_div2">
                            <h2>{{($fillter=='sent')?'الرسائل المرسلة':($fillter=='recieve'?'الرسائل الواردة':'جميع الرسائل')}}</h2>
                            <div class="left_item_search">
                                <form action="/conversations" class="searchForm">
                                    <input type="text" name="q" placeholder="">
                                    <input type="hidden" name="fillter" value="{{$fillter}}">
                                    <input type="hidden" name="page" value="1">
                                    <button  type="submit"><i class="icon-search"></i></button>
                                </form>
                            </div>
                        </div>
                        <div class="left_side_massage publicContent">
                          @include('message.messageItem')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('script')
    <script>
    $('body').on('submit','.searchForm',function () {
        if(!ajaxPaging) {
            ajaxPaging=true;
            elm=$(this);
            elm.find('[type=submit]').children('i').remove();
            elm.find('[type=submit]').html('<i class="fa fa-spin fa-spinner"></i>')
            $.ajax({
                url:elm.attr('action'),
                data:elm.serialize()
            }).done(function(data){
                if(data.status)
                    $('.publicContent').html(data.view);
                else
                    myNoty(data.msg);
                elm.find('[type=submit]').children('i').remove();
                elm.find('[type=submit]').html('<i class="icon-search"></i>')
                ajaxPaging=false;
            });
        }else{
            myNoty('الرجاء انتظار جلب البيانات');
        }
    })
    </script>
@endsection
