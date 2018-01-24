@extends('front.__template')
@section('title','الإشعارات')
@section('content')
 <section class="s_massage">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="all_item_prof">
                        <div class="left_side_massage publicContent">
                          @include('my.notifcation')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
@endsection
