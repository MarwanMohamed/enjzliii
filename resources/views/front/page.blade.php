@extends('front.__template')

@section('title',$page->title)

@section('content')
<style>
 .item_div2 * {
    list-style: initial;
    font-size: initial;
    font: initial;
    vertical-align: initial;
    margin: 0 0 10px;
    font-family: smartmans;
}
  .item_div2 ul {
    padding: inherit;
}
  b, strong{
    font-weight:700 !important;
  }
</style>
 <section class="s_404">
        <div class="container">
            <div class="heade_div404">
                <div class="heade_div">
                    <h2>{{$page->title}}</h2>
                </div>
                <div class="item_div2">
                  {!!$page->text!!}
                </div>
            </div>
        </div>
    </section>
    
@endsection

@section('script')
    <script>

    </script>
@endsection