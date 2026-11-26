<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class MonitorRecoveryController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate(['email' => ['required', 'email', 'max:255']], ['email' => 'Introduce un correo electrónico válido.']);
        if (!config('monitor.password_reset_email_enabled')) {
            return back()->withErrors(['email' => 'La recuperación por correo aún no está disponible. Solicita ayuda al administrador del monitor.']);
        }
        try {
            Password::broker('users')->sendResetLink([
                'email' => mb_strtolower($validated['email']), 'monitor_access' => true,
            ]);
        } catch (TransportExceptionInterface $exception) {
            Log::error('Monitor password recovery delivery failed', ['exception_type' => get_class($exception)]);
        }
        // Same response for unknown, revoked, throttled and registered addresses.
        return back()->with('status', 'Si tu cuenta está habilitada, recibirás instrucciones por correo. Si no llegan, contacta al administrador.');
    }
}
