<?php

use Admark\GoContact\Http\Controllers\MonitorController;
use Illuminate\Support\Facades\Route;

Route::get(config('gocontact.monitor.path', '/monitor/gocontact'), [MonitorController::class, 'index'])
    ->middleware(config('gocontact.monitor.middleware', ['web', 'auth', 'auth.session', 'can:viewGoContactMonitor']))
    ->name('gocontact.monitor');
