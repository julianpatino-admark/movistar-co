<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Support\MonitorPasswordRules;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\ResetsUserPasswords;

class ResetMonitorPassword implements ResetsUserPasswords
{
    public function reset(User $user, array $input): void
    {
        if (!$user->monitor_access) {
            throw ValidationException::withMessages(['email' => __('passwords.token')]);
        }
        Validator::make($input, ['password' => MonitorPasswordRules::rules()], [
            'password' => 'Usa al menos 12 caracteres con letras y números, y confirma la misma contraseña.',
        ])->validate();
        $user->forceFill(['password' => $input['password']])->save();
    }
}
