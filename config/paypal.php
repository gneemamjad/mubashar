<?php

return [
    'client_id' => env('PAYPAL_CLIENT_ID'),
    'client_secret' => env('PAYPAL_SECRET'),

    'mode'    => 'sandbox', // Set 'live' for production
    'sandbox' => [
        'client_id'     => env('PAYPAL_CLIENT_ID'),
        'client_secret' => env('PAYPAL_SECRET'),
        'app_id'        => '',
    ],
    'live'    => [
        'client_id'     => env('PAYPAL_CLIENT_ID'),
        'client_secret' => env('PAYPAL_SECRET'),
        'app_id'        => '',
    ],
    'payment_action' => 'Sale',
    'currency'       => 'USD',
    'notify_url'     => '',
    'locale'         => 'en_US',
    'validate_ssl'   => true,

]; 