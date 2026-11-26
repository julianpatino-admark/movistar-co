<?php

namespace App\Http\Middleware;

use Illuminate\Cache\CacheManager;
use Illuminate\Cache\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Routing\Middleware\ThrottleRequests;

class ThrottleMonitor extends ThrottleRequests
{
    public function __construct(CacheManager $cache)
    {
        // Dedicated persistent store: landing and GoContact token caches are unchanged.
        $limiter = new RateLimiter($cache->store(config('monitor.cache_store', 'database')));
        $limiter->for('monitor-login', fn (Request $request) => [
            Limit::perMinute(5)->by(hash('sha256', mb_strtolower(is_string($request->input('email')) ? $request->input('email') : '').'|'.$request->ip())),
            Limit::perMinute(20)->by('ip:'.$request->ip()),
        ]);
        $limiter->for('monitor-recovery', fn (Request $request) => Limit::perMinutes(10, 3)->by($request->ip()));
        $limiter->for('monitor-password', fn (Request $request) => Limit::perMinute(10)->by($request->ip()));
        $limiter->for('monitor', fn (Request $request) => Limit::perMinute(120)->by($request->ip()));
        parent::__construct($limiter);
    }
}
