<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Actions\PrepareAuthenticatedSession;

class PrepareMonitorSession extends PrepareAuthenticatedSession
{
    public function handle($request, $next)
    {
        $response = parent::handle($request, $next);
        // Bind even sessions that have not yet loaded a protected page to this hash.
        $request->session()->put('password_hash_web', $request->user()->getAuthPassword());
        return $response;
    }
}
