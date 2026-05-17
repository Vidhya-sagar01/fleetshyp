<?php

return [

    'client_id' => env('PHONEPE_CLIENT_ID'),

    'client_secret' => env('PHONEPE_CLIENT_SECRET'),

    'client_version' => (int) env('PHONEPE_CLIENT_VERSION', 1),

    'env' => env('PHONEPE_ENV', 'SANDBOX'),

    'redirect_url' => env('PHONEPE_REDIRECT_URL'),

];