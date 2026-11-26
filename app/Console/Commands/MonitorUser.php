<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Support\MonitorPasswordRules;

class MonitorUser extends Command
{
    protected $signature = 'monitor:user {email} {--name= : Nombre de la persona} {--password-file= : Archivo de contraseña montado desde Secret Manager} {--revoke : Revocar el acceso y las sesiones}';
    protected $description = 'Crear o actualizar una cuenta individual del monitor sin registro público';

    public function handle(): int
    {
        $email = mb_strtolower(trim($this->argument('email')));
        if (Validator::make(['email' => $email], ['email' => 'required|email|max:255'])->fails()) {
            $this->error('Introduce un correo válido.');
            return self::FAILURE;
        }
        $user = User::where('email', $email)->first();
        if ($this->option('revoke')) {
            if (!$user) {
                $this->error('La cuenta no existe.');
                return self::FAILURE;
            }
            $user->forceFill(['monitor_access' => false, 'remember_token' => Str::random(60)])->save();
            Password::broker('users')->deleteToken($user);
            $this->info('Acceso revocado. Las sesiones ya no podrán consultar el monitor.');
            return self::SUCCESS;
        }
        $name = $this->option('name') ?: $user?->name ?: $this->ask('Nombre');
        if ($path = $this->option('password-file')) {
            if (!is_readable($path) || !is_file($path) || filesize($path) > 4096) {
                $this->error('No se puede leer el archivo de contraseña.');
                return self::FAILURE;
            }
            $password = rtrim(file_get_contents($path), "\r\n");
            $confirmation = $password;
        } else {
            $password = $this->secret('Contraseña (mínimo 12 caracteres, con letras y números)');
            $confirmation = $this->secret('Repite la contraseña');
        }
        $validator = Validator::make(['name' => $name, 'password' => $password, 'password_confirmation' => $confirmation], [
            'name' => 'required|string|max:255',
            'password' => MonitorPasswordRules::rules(),
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return self::FAILURE;
        }
        $user ??= new User(['email' => $email]);
        $user->forceFill(['name' => $name, 'password' => $password, 'monitor_access' => true, 'remember_token' => Str::random(60)])->save();
        Password::broker('users')->deleteToken($user);
        $this->info('Cuenta habilitada. Puedes iniciar sesión en /monitor/login.');
        return self::SUCCESS;
    }
}
