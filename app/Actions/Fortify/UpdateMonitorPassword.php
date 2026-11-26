<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Support\MonitorPasswordRules;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;

class UpdateMonitorPassword implements UpdatesUserPasswords
{
    public function update(User $user, array $input): void
    {
        Validator::make($input, [
            'current_password' => ['required', 'string', 'current_password:web'],
            'password' => MonitorPasswordRules::rules(),
        ], [
            'current_password' => 'La contraseña actual no es correcta.',
            'password' => 'Usa al menos 12 caracteres con letras y números, y confirma la misma contraseña.',
        ])->validateWithBag('updatePassword');
        $user->forceFill(['password' => $input['password'], 'remember_token' => Str::random(60)])->save();
    }
}
