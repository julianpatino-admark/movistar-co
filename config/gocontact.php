<?php

return [
    'base_url' => env('GOCONTACT_BASE_URL'),
    'username' => env('GOCONTACT_USERNAME'),
    'password' => env('GOCONTACT_PASSWORD'),
    'database_id' => env('GOCONTACT_DATABASE_ID'),
    'base_path' => env('GOCONTACT_BASE_PATH', '/poll'),
    'token_path' => env('GOCONTACT_TOKEN_PATH', '/auth/token'),
    'contacts_path' => env('GOCONTACT_CONTACTS_PATH', '/api/databases/{database}/contacts'),
    'connect_timeout' => (int) env('GOCONTACT_CONNECT_TIMEOUT', 10),
    'timeout' => (int) env('GOCONTACT_TIMEOUT', 30),
    'token_cache_prefix' => env('GOCONTACT_TOKEN_CACHE_PREFIX', 'admark.gocontact.token'),
    'log_channel' => env('GOCONTACT_LOG_CHANNEL', 'gocontact'),
    'monitor' => [
        'path' => env('GOCONTACT_MONITOR_PATH', '/monitor/gocontact'),
        'username' => env('GOCONTACT_MONITOR_USERNAME'),
        'password' => env('GOCONTACT_MONITOR_PASSWORD'),
    ],
];
