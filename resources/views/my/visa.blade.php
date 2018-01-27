


<?php global $setting;?>

@extends('front.__template')
@section('title','شحن الرصيد')

@section('content')
<div class='clearfix'></div>
            <div class="heade_div2">
                <h2>شحن رصيد</h2>
            </div>
          <form action="{{url('/balance/visa')}}" class="paymentWidgets" data-brands="VISA MASTER AMEX"></form>


@endsection

@section('script')
<script src="https://test.oppwa.com/v1/paymentWidgets.js?checkoutId={{$checkoutId}}"></script>

    <script>
var wpwlOptions = {
        locale: "ar"
    }
    </script>
@endsection