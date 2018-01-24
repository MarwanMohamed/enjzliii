@extends('front.__template')
@section('content')
<style>
.new-cust {
    display: block;
}
.img_div404.new-cust img {
    width: 200px;
}
.text_div404.new-cust h3 {
    font-size: 28px;
    margin-top: 20px;
    margin-bottom: -15px;
}
</style>
    <section class="s_404">
        <div class="container">
            <div class="heade_div404">
<!--                 <div class="heade_div">
                    <h2>حصل خطأ</h2>
                </div> -->
                <div class="item_div">
                    <div class="img_div404 new-cust">
                        <img src="/front/images/404.png">
                    </div>
                    <div class="text_div404 new-cust">
                        @if(session()->has('error'))
                            <h3>{{session('error')}}</h3>
                        @elseif(session()->has('msg'))
                            <h3>{{$msg}}</h3>
                         @else
                            <h3>{{$errors}}</h3>
                        @endif
                    </div>
                    <div class="link_center">
                        <a href="/projects">العودة لصفحة المشاريع</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script>
    </script>
@endsection