<?php

return [

    'default' => env('BROADCAST_CONNECTION', 'ably'),

    'connections' => [

        'ably' => [
            'driver' => 'ably',
            'key'    => env('ABLY_KEY'),
        ],

        'log'  => ['driver' => 'log'],
        'null' => ['driver' => 'null'],

    ],

];
