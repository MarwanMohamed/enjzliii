<section class="some_error">
    <div class="bg_some_error"></div>
    <div class="some_error_item">
        <div class="heade_div2">
            <h2>تبليغ عن محتوى</h2>
            <button class="close_some"><i class="icon-delete"></i></button>
        </div>
        <div class="item_some">
            <h2>قم بإختيار احد الأسباب التالية<span>*</span></h2>
            <form action="/report" id="report">
                <input type="hidden" name="refer_id" value="0">
                <input type="hidden" name="type" value="1">
                @foreach($reportReasons as $key=> $reason)
                    <div class="slideTow">
                        <input type="radio" value="{{$reason->id}}" {{(!$key)?'checked':''}} id="slideTow{{$reason->id}}" name="report" />
                        <label for="slideTow{{$reason->id}}" >{{$reason->value}}</label>
                    </div>
                @endforeach
                <button>إرسال</button>
            </form>
        </div>
    </div>
</section>
</section>