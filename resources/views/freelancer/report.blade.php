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
                <input type="hidden" name="refer_id" id="referIdReport" value="0">
                <input type="hidden" name="type" value="3">
                @foreach($reportReasons as $key=> $reason)
                    <div class="slideTow">
                        <input type="radio" value="{{$reason->id}}" {{(!$key)?'checked':''}} id="slideTow{{$reason->id}}" name="report" />
                        <label for="slideTow{{$reason->id}}" >{{$reason->value}}</label>
                    </div>
                @endforeach
                <button>إرسال <i class="fa fa-spin fa-spinner hidden" id="reportLoader"></i></button>
            </form>
        </div>
    </div>
</section>
<script>
    $(function () {
        $('body').on('click','.reportShow',function (e) {
            e.preventDefault();
            $('#referIdReport').val($(this).data('id'));
            $('.some_error').show();
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

    })
</script>