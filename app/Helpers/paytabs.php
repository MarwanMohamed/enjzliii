<?php
function get_payment_link($first_name, $last_name, $email, $package_title, $unit_price, $currency = 'USD', array $additional_data = []) {

    $msg_lang = 'ar';
    $fields = array_merge([
        //unused default values but must be sent through gateway
        'cc_phone_number' => '973',
        'phone_number' => '555555555',
        'billing_address' => "default",
        'city' => "manama",
        'state' => "Capital",
        'postal_code' => "97300",
        'country' => "BHR",
        'address_shipping' => "Saudi arabia",
        'city_shipping' => "Saudi arabia",
        'state_shipping' => "Capital",
        'postal_code_shipping' => "97300",
        'country_shipping' => "USA",
        "cms_with_version" => "API USING PHP",
        //used default value but sometimes modified
        'discount' => "0",
        "msg_lang" => $msg_lang,
        "reference_no" => strtoupper(str_random(3)) . rand(100000000, 999999999),
        'quantity' => "1",
        'other_charges' => "0", //Additional charges. e.g.: shipping charges, taxes, VAT, etc.
            ], $additional_data);
    
  
    $fields['cc_first_name'] = ucfirst($first_name);
    $fields['cc_last_name'] = ucfirst($last_name?$last_name:$first_name);
    $fields['title'] = implode(' ', [ucfirst($fields['cc_first_name']), ucfirst($fields['cc_last_name'])]);
    $fields['email'] = $email;
    $fields['products_per_title'] = $package_title;
    $fields['currency'] = "USD";
    $fields['unit_price'] = $unit_price;
    $fields['amount'] = $unit_price * $fields['quantity'] + $fields['other_charges'];


    $fields['ip_customer'] = GetIP();
    $fields['ip_merchant'] = $_SERVER['SERVER_ADDR'];

    $fields['return_url'] = url('balance/visa');

    return send_paytabs_request($fields);
}

function verify_payment($payment_reference) {  
    $fields['payment_reference'] = $payment_reference;
    return send_paytabs_request($fields, true);
}



function send_paytabs_request($fields, $isVerify = false) {
    $fields['merchant_email'] = env('PAYTABS_MERCHANT_EMAIL', 'enjzliii@gmail.com');
    $fields['secret_key'] = env('PAYTABS_MERCHANT_SECRET', 'UFfxDNTkQnY0Sr0LS5WFaABfGfbD4ASZg7wUVpfLNdLFFMrxRnc1YOhE3si83b7kjDfe3uZQHKwmxXUok6qjUHYYag7dseyLSNZW');
    $fields['site_url'] = url('/');
    $fields_string = "";
    foreach ($fields as $key => $value) {
        $fields_string .= $key . '=' . $value . '&';
    }

    rtrim($fields_string, '&');
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $isVerify ?: 'http://tapapi.gotapnow.com/TapWebConnect/Tap/WebPay');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "REMOTE_ADDR" => GetIP(),
        "HTTP_X_FORWARDED_FOR" => GetIP()
    ]);
    curl_setopt($ch, CURLOPT_POST, count($fields));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_REFERER, 1);

    $result = curl_exec($ch);
    curl_close($ch);

    return json_decode($result) ?: false;
}