<?php

namespace App\Providers;

use App\Actions\Fortify\ResetMonitorPassword;
use App\Actions\Fortify\UpdateMonitorPassword;
use App\Actions\Fortify\PrepareMonitorSession;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Actions\AttemptToAuthenticate;
use Laravel\Fortify\Actions\CanonicalizeUsername;
use Laravel\Fortify\Fortify;

class MonitorServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Only expose the routes explicitly selected in routes/monitor.php.
        Fortify::ignoreRoutes();
    }

    public function boot(): void
    {
        Fortify::loginView(fn () => view('monitor.auth.login'));
        Fortify::requestPasswordResetLinkView(fn () => view('monitor.auth.forgot-password'));
        Fortify::resetPasswordView(fn ($request) => view('monitor.auth.reset-password', ['request' => $request]));
        Fortify::resetUserPasswordsUsing(ResetMonitorPassword::class);
        Fortify::updateUserPasswordsUsing(UpdateMonitorPassword::class);
        Fortify::authenticateUsing(function ($request) {
            $user = User::where('email', mb_strtolower((string) $request->input('email')))->first();
            return $user && $user->monitor_access && Hash::check($request->input('password'), $user->password) ? $user : null;
        });
        // ThrottleMonitor runs before validation/authentication using its database store.
        Fortify::authenticateThrough(fn () => [CanonicalizeUsername::class, AttemptToAuthenticate::class, PrepareMonitorSession::class]);
    }
}
