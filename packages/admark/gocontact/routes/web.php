<?php

use Admark\GoContact\Http\Controllers\MonitorController;
use Admark\GoContact\Http\Middleware\AuthenticateMonitor;
use Illuminate\Support\Facades\Route;

Route::get(config('gocontact.monitor.path', '/monitor/gocontact'), [MonitorController::class, 'index'])
    ->middleware([AuthenticateMonitor::class, 'throttle:30,1'])
    ->name('gocontact.monitor');
