<?php

namespace Admark\GoContact\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthenticateMonitor
{
    public function handle(Request $request, Closure $next)
    {
        $username = (string) config('gocontact.monitor.username');
        $password = (string) config('gocontact.monitor.password');

        if ($username === '' || $password === '') {
            abort(503, 'GoContact monitor credentials are not configured.');
        }

        $providedUsername = (string) $request->getUser();
        $providedPassword = (string) $request->getPassword();

        if (!hash_equals($username, $providedUsername) || !hash_equals($password, $providedPassword)) {
            return response('Authentication required', 401, [
                'WWW-Authenticate' => 'Basic realm="GoContact monitoring", charset="UTF-8"',
                'Cache-Control' => 'no-store',
            ]);
        }

        return $next($request);
    }
}
