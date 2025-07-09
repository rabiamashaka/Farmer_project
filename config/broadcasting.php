<?php

return [

    /* …connections zingine… */

    'pusher' => [
        'driver'  => 'pusher',
        'key'     => env('PUSHER_APP_KEY'),
        'secret'  => env('PUSHER_APP_SECRET'),
        'app_id'  => env('PUSHER_APP_ID'),

        // OPTIONS lazima ziwe ndani ya array hii
        'options' => [
            'cluster'   => env('PUSHER_APP_CLUSTER', 'mt1'),
            'useTLS'    => true,

            // Chaguo—usiandike kama unatumia cloud Pusher:
            'host'      => env('PUSHER_HOST', null),
            'port'      => env('PUSHER_PORT', 443),
            'scheme'    => env('PUSHER_SCHEME', 'https'),
        ],
    ],

];
