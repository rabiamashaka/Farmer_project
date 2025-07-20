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

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

   'openweather' => [
    'key'     => env('OPENWEATHER_KEY'),
    'url'     => env('OPENWEATHER_URL', 'https://api.openweathermap.org/data/3.0/onecall'),
    'units'   => env('OPENWEATHER_UNITS', 'metric'),
    'exclude' => env('OPENWEATHER_EXCLUDE', 'minutely,hourly,daily,alerts'),
],

'gemini' => [
    'api_key' => env('GEMINI_API_KEY'),
],

'notifyafrican' => [
    'api_key' => env('NOTIFYAFRICA_API_KEY'),
    'base_url' => env('NOTIFYAFRICA_BASE_URL', 'https://api.notify.africa/v2'),
    'sender_id' => env('NOTIFYAFRICA_SENDER_ID', 'YOUR_SENDER_ID'),
],


];
