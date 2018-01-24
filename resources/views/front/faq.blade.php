@extends('front.__template')

@section('title','اسئلة شائعة')

@section('content')
 <section class="s_404">
        <div class="container">
            <div class="heade_div404">
                <div class="heade_div">
                    <h2>أسئلة شائعة</h2>
                </div>
                <div class="item_div2">
                  @foreach($faq as $value)
                    <div class="text_div2 w_b">
                        <h2>{{$value->question}}</h2>
                        <p>{{$value->answer}}</p>
                    </div>
                  
                  @endforeach
                 
                </div>
            </div>
        </div>
    </section>
    
@endsection

@section('script')
    <script>

    </script>
@endsection