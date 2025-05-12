<?php

return [
    'secret_key' => env('KHALTI_SECRET_KEY'),
    'public_key' => env('KHALTI_PUBLIC_KEY'),
    'verify_url' => env('KHALTI_VERIFY_URL', 'https://khalti.com/api/v2/payment/verify/'),
];
