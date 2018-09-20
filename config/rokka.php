<?php

return [
    'organizations' => [
        'default' => [
            'name' => env('ROKKA_ORG'),
            'key' => env('ROKKA_KEY'),
            'requestOptions' => env('ROKKA_REQUEST_OPTIONS', [])
        ],
    ],
];