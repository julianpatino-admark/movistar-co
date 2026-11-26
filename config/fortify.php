<?php

return [
    'guard' => 'web',
    'passwords' => 'users',
    'username' => 'email',
    'email' => 'email',
    'lowercase_usernames' => true,
    'home' => env('GOCONTACT_MONITOR_PATH', '/monitor/gocontact'),
    'views' => true,
    'features' => [],
    'limiters' => ['login' => null],
    'redirects' => ['logout' => '/monitor/login'],
];
