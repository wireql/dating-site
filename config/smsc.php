<?php

return [
    'base_url' => env('SMSC_BASE_URL', 'https://smsc.kz'),
    'login' => env('SMSC_LOGIN'),
    'password' => env('SMSC_PASSWORD'),
    'charset' => env('SMSC_CHARSET', 'utf-8'),
    'https' => env('SMSC_HTTPS', false),
    'debug' => env('SMSC_DEBUG', false),
];