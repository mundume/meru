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

    'africastalking_key' => env('AFRICASTALKING_KEY', ''),
    'africastalking_secret' => env('AFRICASTALKING_SECRET', ''),
    'africastalking_env' => env('AFRICASTALKING_ENV', ''),
    'xwift_api_key' => env('XWIFT_API_KEY', ''),
    'xwift_url' => env('XWIFT_URL', ''),
    'stk_push_url' => env('STK_PUSH_URL', ''),
    'generate_token_url' => env('GENERATE_TOKEN_URL', '')
];
