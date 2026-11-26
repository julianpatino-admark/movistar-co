<?php

return [
    'cache_store' => env('MONITOR_CACHE_STORE', 'database'),
    'password_reset_email_enabled' => (bool) env('MONITOR_PASSWORD_RESET_EMAIL_ENABLED', false),
    'public_url' => env('MONITOR_PUBLIC_URL', 'https://ofertastienda.co'),
];
