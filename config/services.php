<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    //Socialite
    'facebook' => [
        'client_id'     => '1701857136522609',
        'client_secret' => '227ff88f8280fdf42e4b650a44e256e4',
        'redirect'      => 'https://enjzli.com/callbackFacebook',
    ],    //Socialite
    'twitter' => [
        'client_id'     => 'odFiQjxa0Lj0dh27w4SOKMtQc',
        'client_secret' => '63TljVzutLS87h1UX3rnLF0eJNRUQ9uWmj0e1bUfrzMnGF4c8Y',
        'redirect'      => 'https://enjzli.com/callbackTwitter',
    ],


];
