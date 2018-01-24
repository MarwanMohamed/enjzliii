@extends('front.__template')
@section('content')
    <section class="s_404">
        <div class="container">
            <div class="heade_div404">
<!--                 <div class="heade_div">
                    <h2>404 الصفحة غير موجودة</h2>
                </div> -->
                <div class="item_div">
                    <div class="text_div404">
                        <h2>404</h2>
                        <h3>الصفحة غير متوفرة</h3>
                    </div>
                    <div class="img_div404">
                        <img src="/front/images/404.png">
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