<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'braintree' => [
        'environment' => env('BRAINTREE_ENVIRONMENT', 'sandbox'),
        'merchantId' => env('BRAINTREE_MERCHANT_ID', 'k7gt3kbmdg6t2j8j'),
        'publicKey' => env('BRAINTREE_PUBLIC_KEY', '29mskcds7qk9fr2g'),
        'privateKey' => env('BRAINTREE_PRIVATE_KEY', 'a44c2cd027c83206e1ed2298f4010c95')
    ]

];
