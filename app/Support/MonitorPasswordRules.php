<?php

namespace App\Support;

use Illuminate\Validation\Rules\Password;

class MonitorPasswordRules
{
    public static function rules(): array
    {
        return ['required', 'string', Password::min(12)->letters()->numbers(), 'confirmed',
            function ($attribute, $value, $fail) {
                // Bcrypt accepts at most 72 bytes, regardless of character count.
                if (is_string($value) && (strlen($value) > 72 || str_contains($value, "\0"))) {
                    $fail('La contraseña es demasiado larga o contiene caracteres no admitidos. Usa una más corta.');
                }
            },
        ];
    }
}
